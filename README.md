PHP SDK for CodebaseHQ API
==========================

[CodebaseHQ](http://www.codebasehq.com/) is software project management tool with Git, Mercurial and Subversion hosting,
bug and time tracking, and more.


Installation
------------
This package can be installed using Composer:

```js
{
    "minimum-stability": "dev",
    "require": {
        "mtymek/codebasehq-sdk": "dev-master"
    }
}
```

Usage
-----

Please refer to [this document](http://support.codebasehq.com/kb/api-documentation) for general information about
CodebaseHQ API.

First, you need to create API client, and pass your account, username and API key:

```php
$client = new CodebaseHq\Api('someaccount', 'mtymek', '85j9axug8r2mb42ao5rf59nrpstesdujbj05x2ih');
```

At this moment PHP SDK supports only low-level calls that work on XML data:

```php
// Example: listing all assigned tickets
$result = $api->api('/mats-playground/tickets?query=' . urlencode('assignee:me'));
$xml = new SimpleXMLElement($result);
foreach ($xml->ticket as $ticket) {
    echo $ticket->{'ticket-id'} . ': ' . $ticket->summary, "\n";
}

// Example: tracking time session
$xml = '<time-session><summary>Worked on the awesome feature</summary><minutes>60:00</minutes></time-session>';
$api->api('/mats-playground/time_sessions', 'POST', $xml);
```

You can avoid passing XML directly by using `buildXml()` helper method:

```php
// Example: ticket update
$ticketNote = array(
    'content' => 'Lorem Ipsum dolor sit amet.',
    'time-added' => '1:00'
);
$result = $api->api('/mats-playground/tickets/263/notes', 'POST', $api->buildXml('ticket-note', $ticketNote));
```

TODO
----

* basic, low-level API access [IMPLEMENTED]
* nice, object-oriented interface for accessing all types of records defined by CodebaseHQ API [TBD]
