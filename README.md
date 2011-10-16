#Blast Template#

A simple template engine for PHP.

##Why?##

Blast Template is designed to be a piece of a larger framework called Blast. Originally, Blast used pure PHP templates but has developed the need for a safer alternative for end-users.

In short you may want to use Blast Template if:

* Smarty is too much.
* Your own patchwork attempt at a template engine will no longer cut it.
* You cannot expose PHP to designers or end-users.
* You need (what will ultimately be) a fully tested, reliable template engine for simple tasks.

##Template Syntax##

Single variable replacement:

```html
<h1>Hello, {name}!</h1>
```

Looping over arrays using blocks (nested blocks are also supported):

```html
{block:messages}
	<h3>{subject}</h3>
	<p>{content}</p>
{/block:messages}
```

**Proposed** conditional blocks:

```html
{if:error_message}
	<p>{error_message}</p>
{/if:error_message}
```

##API##

This API will be evolving over the course of development. However, this is what you can expect from the current state of the project.

```php
<?php
include 'template.php';

$name = 'Jason';
$messages = array(
	array('subject' => 'Welcome', 'content' => 'Hope you enjoy the Blast Template engine!'),
	array('subject' => 'Examples', 'content' => 'In the tests directory, you can find plenty of examples!')
);

$tmpl = new Template();
$tmpl->load('example.html');
$tmpl->assign('name', $name);
$tmpl->assign('messages', $messages);
$tmpl->render();
?>
```
