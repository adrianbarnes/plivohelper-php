<?php

    /*
    The RESTXML PHP Response Library makes it easy to write RESTXML without having
    to touch XML. Error checking is built in to help preventing invalid markup.

    USAGE:
    To create RESTXML, you will make new RESTXML grammar and nest them inside another
    RESTXML verb. Convenience methods are provided to simplify RESTXML creation.
    */

    include ('../plivohelper.php');

    // ========================================================================
    // Using Speak, Dial, and Play
    $r = new Response();
    $r->append(new Speak("Hello World", array("loop" => "10")));
    $g = new Dial(array("timeLimit" => "45"));
    $g->append(new Number("4155551212"));
    $r->append($g);
    $r->append(new Play("http://www.mp3.com"));
    $r->Respond();

    /* outputs:
    <Response>
        <Speak loop="10">Hello World</Speak>
        <Dial timeLimit="45">
            <Number>4155551212</Number>
        </Dial>
        <Play>http://www.mp3.com</Play>
    </Response>
    */

    // The same XML can be created above using the convencience methods
    $r = new Response();
    $r->addSpeak("Hello World", array("loop" => "10"));
    $g = $r->addDial(array("timeLimit" => "45"));
    $g->addNumber("4155551212");
    $r->addPlay("http://www.mp3.com");
    $r->addHangup(array("schedule" => "45"));
    $r->Respond();

    // ========================================================================
    // GetDigits, Redirect
    $r = new Response();
    $g = $r->addgetDigits(array("numDigits" => "1", "timeout" => "25",
            "playBeep" => "true"));
    $g->addPlay("/usr/local/freeswitch/sounds/en/us/callie/ivr/8000/ivr-hello.wav", array("loop" => "10"));
    $r->addWait(array("length" => "5"));
    $r->addPlay("/usr/local/freeswitch/sounds/en/us/callie/ivr/8000/ivr-hello.wav", array("loop" => "10"));
    $r->addRecord(array("bothLegs" => "true"));
    $r->addredirect();
    $r->Respond();


    /* outputs:
    <Response>
        <GetDigits numdigits="1">
            <Play loop="2">/usr/local/freeswitch/sounds/en/us/callie/ivr/8000/ivr-hello.wav</Play>
        </GetDigits>
        <Wait length="5"/>
        <Play loop="2">/usr/local/freeswitch/sounds/en/us/callie/ivr/8000/ivr-hello.wav</Play>
        <Record/>
        <Hangup/>
    </Response>
    */

    // ========================================================================
    // Add a Speak verb multiple times
    $r = new Response();
    $say = new Speak("Press 1");
    $r->append($say);
    $r->append($say);
    $r->Respond();


    /*
    <Response>
        <Speak>Press 1</Speak>
        <Speak>Press 1</Speak>
    </Response>
    */


    // ========================================================================
    // Set any attribute / value pair
    // You may want to add an attribute to a verb that the library does not
    // support. This can be accomplished by putting __ in front o the
    // attribute name
    $r = new Response();
    $redirect = new Redirect();
    $redirect->set("crazy","delicious");
    $r->append($redirect);
    $r-> Respond();

    /*
    <Response>
        <Redirect crazy="delicious"/>
    </Response>
    */
