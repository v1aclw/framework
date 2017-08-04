<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 16:38
 */

namespace App\Router;

use App\Request;
use App\Request\{
    Files,
    File
};

/**
 * Class Processor
 *
 * @package App\Router
 */
abstract class Processor implements IProcessor
{

    /**
     * @param \ReflectionFunctionAbstract $reflection
     * @param Request $request
     * @return array
     */
    protected function getReflectionParameters(\ReflectionFunctionAbstract $reflection, Request $request) {
        $parameters = [];
        foreach ($reflection->getParameters() as $key => $parameter) {
            if ((string)$parameter->getType() === 'App\Request') {
                $parameters[$key] = $request;
                continue;
            }
            if ((string)$parameter->getType() === 'App\Request\Files') {
                $parameters[$key] = $request->files();
                continue;
            }
            if ((string)$parameter->getType() === 'App\Request\TempFile' && $request->files()->isset($parameter->getName())) {
                $parameters[$key] = $request->files()->get($parameter->getName());
                continue;
            }
            if ((string)$parameter->getType() === 'App\Request\Session') {
                $parameters[$key] = $request->session();
                continue;
            }
            if (array_key_exists($parameter->getName(), $request->route()->getData())) {
                $parameters[$key] = $request->route()->getData()[$parameter->getName()];
            } elseif (array_key_exists($parameter->getName(), $request->input())) {
                $parameters[$key] = $request->input()[$parameter->getName()];
            } elseif (array_key_exists($parameter->getName(), $request->form())) {
                $parameters[$key] = $request->form()[$parameter->getName()];
            }
            if (array_key_exists($key, $parameters) && $parameter->hasType()) {
                switch ((string)$parameter->getType()) {
                    case 'int' :
                        $parameters[$key] = (int)$parameters[$key];
                        break;
                    case 'float' :
                        $parameters[$key] = (float)$parameters[$key];
                        break;
                    case 'string' :
                        $parameters[$key] = (string)$parameters[$key];
                        break;
                    case 'bool' :
                        $parameters[$key] = (bool)$parameters[$key];
                        break;
                    case 'array' :
                        if (!is_array($parameters[$key])) {
                            unset($parameters[$key]);
                        }
                        break;
                    default:
                        unset($parameters[$key]);
                }
            }
            if (!array_key_exists($key, $parameters) && $parameter->isOptional()) {
                $parameters[$key] = $parameter->getDefaultValue();
            }
            if (!array_key_exists($key, $parameters)) {
                throw new \InvalidArgumentException();
            }
        }
        return $parameters;
    }

}