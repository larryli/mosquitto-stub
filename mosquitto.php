<?php
/**
 * mosquitto.php
 *
 * Creation date: 2014-07-10
 * Creation time: 17:00
 *
 * @author Arkadiusz Moskwa <a.moskwa@gmail.com>
 */

namespace Mosquitto;

/**
 * This is the actual Mosquitto client.
 *
 * @package Mosquitto
 */
class Client
{
    /**
     * Construct a new Client instance.
     *
     * @param string|null  $id The client ID. If omitted or null, one will be generated at random.
     * @param boolean $cleanSession Set to true to instruct the broker to clean all messages and subscriptions on
     * disconnect. Must be true if the $id parameter is null.
     */
    public function __construct($id = null, $cleanSession = true) {}

    /**
     * Set the username and password to use on connecting to the broker. Must be called before `connect()`.
     *
     * @param string    $username Username to supply to the broker
     * @param string    $password Password to supply to the broker
     */
    public function setCredentials($username, $password) {}

    /**
     * Configure the client for certificate based SSL/TLS support. Must be called before `connect()`. Cannot be used in
     * conjunction with `setTlsPSK()`.
     * <br/><br/>
     * Define the Certificate Authority certificates to be trusted (ie. the server certificate must be signed with
     * one of these certificates) using `$cafile`. If the server you are connecting to requires clients to provide a
     * certificate, define `$certfile` and `$keyfile` with your client certificate and private key. If your private key is
     * encrypted, provide the password as the fourth parameter, or you will have to enter the password at the command
     * line.
     *
     * @param string $capath Path to the PEM encoded trusted CA certificate files, or to a directory containing them
     * @param string $certfile Path to the PEM encoded certificate file for this client. Optional.
     * @param string $keyfile Path to a file containing the PEM encoded private key for this client. Required if certfile is set.
     * @param string $password The password for the keyfile, if it is encrypted. If null, the password will be asked for on the command line.
     */
    public function setTlsCertificates($capath, $certfile = null, $keyfile = null, $password = null) {}

    /**
     * Configure verification of the server hostname in the server certificate. If `$value` is `true`, it is impossible
     * to guarantee that the host you are connecting to is not impersonating your server. Do not use this function in
     * a real system. Must be called before `connect()`.
     *
     * @param boolean $value If set to false, the default, certificate hostname checking is performed. If set to `true`,
     * no hostname checking is performed and the connection is insecure.
     */
    public function setTlsInsecure($value) {}

    /**
     * Set advanced SSL/TLS options. Must be called before `connect()`.
     *
     * @param int    $certReqs   Whether or not to verify the server. Can be `Mosquitto\Client::SSL_VERIFY_NONE`,
     *                           to disable certificate verification, or `Mosquitto\Client::SSL_VERIFY_PEER` (the
     *                           default), to verify the server certificate.
     * @param string $tlsVersion The TLS version to use. If `null`, a default is used. The default value depends on the
     *                           version of OpenSSL the library was compiled against. Available options on OpenSSL >=
     *                           1.0.1 are `tlsv1.2`, `tlsv1.1` and `tlsv1`.
     * @param string $cipers     A string describing the ciphers available for use. See the `openssl ciphers` tool for
     *                           more information. If `null`, the default set will be used.
     */
    public function setTlsOptions($certReqs, $tlsVersion, $cipers) {}

    /**
     * Configure the client for pre-shared-key based TLS support. Must be called before `connect()`. Cannot be used in
     * conjunction with `setTlsCertificates()`.
     *
     * @param string    $psk        The pre-shared key in hex format with no leading "0x".
     * @param string    $identity   The identity of this client. May be used as the username depending on server
     *                              settings.
     * @param string    $cipers     A string describing the ciphers available for use. See the openssl ciphers tool
     *                              for more information. If NULL, the default set will be used.
     */
    public function setTlsPSK($psk, $identity, $cipers) {}

    /**
     * Set the client "last will and testament", which will be sent on an unclean disconnection from the broker.
     * Must be called before `connect()`.
     *
     * @param string    $topic      The topic on which to publish the will.
     * @param string    $payload    The data to send.
     * @param int       $qos        Optional. Default 0. Integer 0, 1, or 2 indicating the Quality of Service to be used.
     * @param boolean   $retain     Optional. Default false. If `true`, the message will be retained.
     */
    public function setWill($topic, $payload, $qos = 0, $retain = false) {}

    /**
     * Remove a previously-set will. No parameters.
     */
    public function clearWill() {}

    /**
     * Control the behaviour of the client when it has unexpectedly disconnected in `loopForever()`. The default
     * behaviour if this method is not used is to repeatedly attempt to reconnect with a delay of 1 second until the
     * connection succeeds.
     *
     * @param int       $reconnectDelay         Set delay between successive reconnection attempts.
     * @param int       $exponentialDelay       Set max delay between successive reconnection attempts when
     *                                          exponential backoff is enabled
     * @param boolean   $exponentialBackoff     Pass `true` to enable exponential backoff
     */
    public function setReconnectDelay($reconnectDelay, $exponentialDelay, $exponentialBackoff) {}

    /**
     * Connect to an MQTT broker.
     *
     * @param string    $host       Hostname to connect to
     * @param int       $port       Optional. Port number to connect to. Defaults to 1883.
     * @param int       $keepalive  Optional. Number of sections after which the broker should PING the client if no
     *                              messages have been received.
     * @param string    $interface  Optional. The address or hostname of a local interface to bind to for this connection.
     */
    public function connect($host, $port = 1883, $keepalive = 60, $interface = null) {}

    /**
     * Disconnect from the broker. No parameters.
     */
    public function disconnect() {}

    /**
     * Set the connect callback. This is called when the broker sends a CONNACK message in response to a connection.
     *
     * @param callback $callback    The callback
     *
     * ```php
     * function ($rc, $message)
     * ```
     *
     * The callback should take parameters of the form:
     *
     * $rc (int) – Response code from the broker.
     *
     * $message (string) – String description of the response code.
     *
     * Response codes are as follows:
     *
     * Code |	Meaning
     * ---- | ----
     * 0	| Success
     * 1	| Connection refused (unacceptable protocol version)
     * 2	| Connection refused (identifier rejected)
     * 3	| Connection refused (broker unavailable )
     * 4-255 | 	Reserved for future use
     *
     * @link https://github.com/mgdm/Mosquitto-PHP#onconnect
     */
    public function onConnect($callback) {}

    /**
     * Set the disconnect callback. This is called when the broker has received the DISCONNECT command and has
     * disconnected the client.
     *
     * @param callback $callback The callback
     *
     * ```php
     * function ($rc)
     * ```
     *
     * The callback should take parameters of the form:
     *
     * $rc (int) – Reason for the disconnection. 0 means the client requested it.
     * Any other value indicates an unexpected disconnection.
     *
     * @link https://github.com/mgdm/Mosquitto-PHP#ondisconnect
     */
    public function onDisconnect($callback) {}

    /**
     * Set the logging callback.
     *
     * @param callback $callback The callback
     *
     * ```php
     * function ($level, $str)
     * ```
     *
     * The callback should take parameters of the form:
     *
     * $level (int) – The log message level from the values below
     * $str (string) – The message string.
     *
     * The level can be one of:
     *
     * - `Client::LOG_DEBUG`
     * - `Client::LOG_INFO`
     * - `Client::LOG_NOTICE`
     * - `Client::LOG_WARNING`
     * - `Client::LOG_ERR`
     *
     * @link https://github.com/mgdm/Mosquitto-PHP#onlog
     */
    public function onLog($callback) {}

    /**
     * Set the subscribe callback. This is called when the broker responds to a subscription request.
     *
     * @param callback $callback The callback
     *
     * ```php
     * function ($mid, $qosCount)
     * ```
     *
     * The callback should take parameters of the form:
     *
     * $mid (int) – Message ID of the subscribe message
     * $qosCount (int) – Number of granted subscriptions
     *
     * This function needs to return the granted QoS for each subscription, but currently cannot.
     *
     * @link https://github.com/mgdm/Mosquitto-PHP#onsubscribe
     */
    public function onSubscribe($callback) {}

    /**
     * Set the unsubscribe callback. This is called when the broker responds to a unsubscribe request.
     *
     * @param callback $callback The callback
     *
     * ```php
     * function ($mid, $qosCount)
     * ```
     *
     * The callback should take parameters of the form:
     *
     * $mid (int) – Message ID of the unsubscribe message
     *
     * @link https://github.com/mgdm/Mosquitto-PHP#onunsubscribe
     */
    public function onUnsubscribe($callback) {}

    /**
     * Set the message callback. This is called when a message is received from the broker.
     *
     * @param callback $callback The callback
     *
     * ```php
     * function ($message)
     * ```
     *
     * The callback should take parameters of the form:
     *
     * $message (Message) - A `Message` object containing the message data
     *
     * @link https://github.com/mgdm/Mosquitto-PHP#onmessage
     */
    public function onMessage($callback) {}

    /**
     * Set the publish callback. This is called when a message is published by the client itself.
     * <br><br>
     * *Warning:* this may be called before the method publish returns the message id, so, you need to create a queue
     * to deal with the MID list.
     *
     * @param callback $callback The callback
     *
     * ```php
     * function ($mid)
     * ```
     *
     * The callback should take parameters of the form:
     *
     * $mid (int) – the message id returned by `publish()`
     *
     * @link https://github.com/mgdm/Mosquitto-PHP#onpublish
     */
    public function onPublish($callback) {}

    /**
     * Set the number of QoS 1 and 2 messages that can be “in flight” at one time. An in flight message is part way
     * through its delivery flow. Attempts to send further messages with publish() will result in the messages being
     * queued until the number of in flight messages reduces.
     * <br/> <br/>
     * Set to 0 for no maximum.
     *
     * @param int $maxInFlightMessages  The maximum
     */
    public function setMaxInFlightMessages($maxInFlightMessages ) {}

    /**
     * Set the number of seconds to wait before retrying messages. This applies to publish messages with QoS>0. May
     * be called at any time.
     *
     * @param int $messageRetryPeriod  The retry period

     */
    public function setMessageRetry($messageRetryPeriod) {}

    /**
     * Publish a message on a given topic.
     *
     * @param string    $topic      The topic to publish on
     * @param string    $payload    The message payload
     * @param int       $qos        Integer value 0, 1 or 2 indicating the QoS for this message
     * @param boolean   $retain     If `true`, make this message retained
     * @return int                  The message ID returned by the broker. Warning: the message ID is not unique.
     */
    public function publish($topic, $payload, $qos, $retain) {}

    /**
     * Subscribe to a topic.
     *
     * @param   string    $topic    The topic.
     * @param   int       $qos      The QoS to request for this subscription
     * @return  int                 Returns the message ID of the subscription message,
     *                              so this can be matched up in the `onSubscribe()` callback.
     */
    public function subscribe($topic, $qos) {}

    /**
     * Unsubscribe from a topic.
     *
     * @param   string    $topic  The topic.
     * @param   int       $qos    The QoS to request for this subscription
     *
     * @return  int               Returns the message ID of the subscription message,
     *                            so this can be matched up in the `onUnsubscribe()` callback.
     */
    public function unsubscribe($topic, $qos) {}

    /**
     * The main network loop for the client. You must call this frequently in order to keep communications between
     * the client and broker working. If incoming data is present it will then be processed. Outgoing commands,
     * from e.g. `publish()`, are normally sent immediately that their function is called,
     * but this is not always possible. `loop()` will also attempt to send any remaining outgoing messages,
     * which also includes commands that are part of the flow for messages with QoS>0.
     *
     * @param int $timeout      Optional. Number of milliseconds to wait for network activity. Pass 0 for instant
     *                          timeout. Defaults to 1000.
     */
    public function loop($timeout = 1000) {}

    /**
     * Call `loop()` in an infinite blocking loop. Callbacks will be called as required. This will handle reconnecting
     * if the connection is lost. Call `disconnect()` in a callback to return from the loop.
     * <br/><br/>
     * Note: exceptions thrown in callbacks do not currently cause the loop to exit. To work around this,
     * use `loop()` and wrap your own loop structure around it such as a while().
     *
     * @param int $timeout      Optional. Number of milliseconds to wait for network activity. Pass 0 for instant
     *                          timeout. Defaults to 1000.
     */
    public function loopForever($timeout = 1000) {}

    /**
     * Exit the loopForever event loop without disconnecting. You will need to re-enter the loop afterwards in order to
     * maintain the connection.
     */
    public function exitLoop() {}
}

/**
 * Represents a message received from a broker. All data is represented as properties.
 *
 * @package Mosquitto
 */
class Message
{
    /**
     * @var string  The topic this message was delivered to.
     */
    public $topic;

    /**
     * @var string  The payload of this message.
     */
    public $payload;

    /**
     * @var int     The ID of this message.
     */
    public $mid;

    /**
     * @var int     The QoS value applied to this message.
     */
    public $qos;

    /**
     * @var boolean Whether this is a retained message or not.
     */
    public $retain;

    /**
     * Returns true if the supplied topic matches the supplied description, and otherwise false.
     *
     * @param  string  $topic         The topic to match
     * @param  string  $subscription  The subscription to match
     * @return boolean
     */
    public static function topicMatchesSub($topic, $subscription) {}

    /**
     * Tokenise a topic or subscription string into an array of strings representing the topic hierarchy.
     *
     * @param  string $topic
     * @return array
     */
    public static function tokeniseTopic($topic) {}
}

/**
 * This is an exception that may be thrown by many of the operations in the `Client` object.
 * It does not add any features to the standard PHP `Exception` class.
 *
 * @package Mosquitto
 */
class Exception
{

}