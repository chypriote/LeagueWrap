<?php
namespace LeagueWrap;

class Response {

	/**
	 * The content of the response.
	 *
	 * @var string
	 */
	protected $content;

	/**
	 * The HTTP code resulting from the request.
	 *
	 * @var integer
	 */
	protected $code;

	/**
	 * The primary content of the response.
	 *
	 * @param string $content
	 * @param int $code
	 */
	public function __construct($content, $code)
	{
		$this->content = trim($content);
		$this->code    = intval($code);
	}

	/**
	 * Returns the content of the response as a string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->content;
	}

	/**
	 * Returns the code associated with the response.
	 *
	 * @return int
	 */
	public function getCode()
	{
		return $this->code;
	}
}
