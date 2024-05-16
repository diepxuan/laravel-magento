<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-05-16 11:20:23
 */

namespace Diepxuan\Magento\Models;

use Diepxuan\Magento\Http\Request;
use Illuminate\Support\Str;

#[AllowDynamicProperties]
abstract class Model extends \stdClass
{
    protected $entity;
    protected $primaryKey;
    protected $modelClass = self::class;
    protected $fillable   = [];

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request, $data = [])
    {
        $this->request    = $request;
        $this->modelClass = static::class;
        $data             = (array) $data;

        foreach ($data as $key => $value) {
            $customSetterMethod = 'set' . ucfirst(Str::camel($key)) . 'Attribute';

            if (!method_exists($this, $customSetterMethod)) {
                $this->setAttribute($key, $value);
            } else {
                $this->setAttribute($key, $this->{$customSetterMethod}($value));
            }
        }
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        $data       = [];
        $class      = new \ReflectionObject($this);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

        /** @var \ReflectionProperty $property */
        foreach ($properties as $property) {
            $data[$property->getName()] = $this->{$property->getName()};
        }

        return $data;
    }

    public function delete()
    {
        return $this->request->handleWithExceptions(fn () => $this->request->client->delete("{$this->entity}/" . urlencode("{$this->{$this->primaryKey}}")));
    }

    public function update($data = [])
    {
        $data = [
            Str::singular($this->entity) => $data,
        ];

        return $this->request->handleWithExceptions(function () use ($data) {
            $response = $this->request->client->put("{$this->entity}/" . urlencode("{$this->{$this->primaryKey}}"), [
                'json' => $data,
            ]);

            $responseData = json_decode((string) $response->getBody());

            return new $this->modelClass($this->request, $responseData);
        });
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity($new_entity): void
    {
        $this->entity = $new_entity;
    }

    protected function setAttribute($attribute, $value): void
    {
        $this->{$attribute} = $value;
    }
}
