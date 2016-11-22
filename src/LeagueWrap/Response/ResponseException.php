<?php

namespace LeagueWrap\Response;

use Exception;
use LeagueWrap\Exception\NoResponseIncludedException;
use LeagueWrap\Response;
use Serializable;

abstract class ResponseException extends Exception implements Serializable
{
    /**
     * Response that caused this exception.
     *
     * @var Response
     */
    protected $response;

    /**
     * Static constructor for including response.
     *
     * @param string   $message
     * @param Response $response
     *
     * @return static
     */
    public static function withResponse($message, Response $response)
    {
        $e = new static();
        $e->response = $response;
        $e->message = $message;

        return $e;
    }

    /**
     * Check if response was provided.
     *
     * @return bool
     */
    public function hasResponse()
    {
        return (bool) $this->response;
    }

    /**
     * Access the response.
     *
     * @throws NoResponseIncludedException
     *
     * @return Response
     */
    public function getResponse()
    {
        if (!$this->response) {
            throw new NoResponseIncludedException(
                'No response information was provided. '.
                'Use hasResponse() to check if this exception has response attached.'
            );
        }

        return $this->response;
    }

    public function serialize()
    {
        return serialize([$this->response, $this->message, $this->code, $this->line, $this->file]);
    }

    public function unserialize($data)
    {
        list($this->response, $this->message, $this->code, $this->line, $this->file) = unserialize($data);
    }
}
