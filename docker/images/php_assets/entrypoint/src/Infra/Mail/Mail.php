<?php namespace Util\Infra\Mail;

/**
 * Class Mail
 * @package Util\Infra\Mail
 */
class Mail
{
    /**
     * @var string Wonderful Subject
     */
    protected $subject = "";

    /**
     * @var array array('john@doe.com' => 'John Doe')
     */
    protected $from = array();

    /**
     * @var array array('receiver@domain.org', 'other@domain.org' => 'A name')
     */
    protected $to = array();

    /**
     * @var string Here is the message itself
     */
    protected $body = "";

    /**
     * @var null|\Swift_MailTransport
     */
    protected $transport = null;

    /**
     * Mail constructor.
     */
    public function __construct()
    {
        \Swift::init(function () {
            \Swift_DependencyContainer::getInstance()
                ->register('mime.qpheaderencoder')
                ->asAliasOf('mime.base64headerencoder');
            \Swift_Preferences::getInstance()->setCharset('iso-2022-jp');
        });

        $this->transport = \Swift_MailTransport::newInstance();
    }

    /**
     * メールの送信
     * @return int
     */
    public function send()
    {
        $mailer = \Swift_Mailer::newInstance($this->transport);

        $message = \Swift_Message::newInstance( $this->subject )
            ->setFrom( $this->from )
            ->setTo( $this->to )
            ->setBody( $this->body );

        return $mailer->send($message);
    }

    /**
     * @param $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param array $from
     */
    public function setFrom(array $from)
    {
        $this->from = $from;
    }

    /**
     * @param array $to
     */
    public function setTo(array $to)
    {
        $this->to = $to;
    }

    /**
     * @param $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}