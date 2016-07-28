#**agendor-php** #

[![Code Climate](https://codeclimate.com/github/ivanwitzke/agendor-php/badges/gpa.svg)](https://codeclimate.com/github/ivanwitzke/agendor-php)

###**About**###

This is a php lib to be used with the [Agendor API](http://www.agendor.com.br).
To use it you will first need an API Token, that can be found [here](https://web.agendor.com.br/sistema/integracoes/)

###**Install**###
Install it using [Composer](https://getcomposer.org/):

`composer require ivanwitzke/agendor-php`

or download the [latest zip file](https://github.com/ivanwitzke/agendor-php/archive/master.zip) and extract to your project folder, then require the `agendor-php/Agendor.php` file.

    <php
        require("PATH_TO_PROJECT_FOLDER/agendor-php/Agendor.php");
        

 
Then on the controller (where you are going to use it) we set the API Key / Token

`Ivanwitzke\Agendor\Agendor::setApiKey('YOURTOKEN');`

###**The models**###

The Agendor API supports requests to "People", "Organization", "Task" and "Deal". Each one of those are represented by a Class with the same name on this lib, and have the same properties as defined on the [Api docs](http://docs.agendor.apiary.io).

###**The Methods**###
**Requesting all items (paginated)**

   `$page` is the page to be returned;
   `$limit` is how many items per page;

    $peopleList = Ivanwitzke\Agendor\People::all($page, $limit);
    $orgsList = Ivanwitzke\Agendor\Organization::all($page, $limit);
    $dealsList = Ivanwitzke\Agendor\Deal::all($page, $limit);
    $tasksList = Ivanwitzke\Agendor\Task::all($page, $limit);

**Request one item**

    $person = Ivanwitzke\Agendor\People::findById($peopleId);
    $org = Ivanwitzke\Agendor\Organization::findById($organizationId);
    $deal = Ivanwitzke\Agendor\Deal::findById($dealId);
    $task = Ivanwitzke\Agendor\Task::findById($taskId);

**Creating a new item**

Create a new object instance passing an array with all the info needed and then run `$object->create();`

*Example:*

    $personData = array(
	    "name" => "Person Name",
	    "role" => "Manager",
	    "emails" => array(
		    "mail1@mail.com",
			"mail2@mail.com"
			"mailN@mail.com"
	    ),
	    "address" => array(
			"postalCode" => 12345678, // numbers only
			"streetName" => "Example Street",
			"streetNumber" => 9999 // numbers only
	    );
    );
    
    $person = new Ivanwitzke\Agendor\People($personData);
	
	try {
		$person->create();
	} catch (Exception $e) {
		die($e->getMessage());
	}

Or use the "*set*" methods:
set + property name camel cased (`Ex: $object->setName("Item Name");`)

*Example:*

    $person = new Ivanwitzke\Agendor\People();
    $person->setName("Person Name");
    $person->setCategoryId(123);

    $mobilePhone = new Ivanwitzke\Agendor\Object();
    $mobilePhone->setType('mobile');
    $mobilePhone->setNumber("1198765432");

    $workPhone = new Ivanwitzke\Agendor\Object();
    $workPhone->setType('work');
    $workPhone->setNumber("1198765432");

    $person->setPhones(array($mobilePhone, $workPhone));
    
    $address = new Ivanwitzke\Agendor\Object();
    $address->setStreetName("Street");
    $address->setStreetNumber(999); // Must be number
    $address->setCountry("Country");

    $person->setAddress($address);
   	
   	try {
		$person->create();
	} catch (Exception $e) {
		die($e->getMessage());
	}

If everything goes well, the response will be the object instance, otherwise it will throw the error sent from the API.

For properties that must be passed as an object to the API (like the `Ivanwitzke\Agendor\People->address`, there is a generic `Ivanwitzke\Agendor\Object` class that you can instantiate and use to set  its values just like any other of the main classes.

*Obs: They can also be set as an array.*

**Updating data**

First we find what to update:
    
`$organization = Ivanwitzke\Agendor\Organization::findById($id);`

then we update whatever we need and save

    if ($organization) { // We update only if the item was found
        $organization->setNickname("New nickname");
        $organization->setLegalName("New Legal Name");
        $organization->setEmails(array($newEmail));
        // Address property can be an Array or an Agendor\Object() instance;
        $organization->setAddress(array(
            'postalCode' => $newPostalCode, // numbers only;
            'streetName' => $newStreetName,
            'streetNumber' => $newStreetNumber // Also only numbers;
        ));
        try {
            $organization->save(); // Save the changes
        } catch (Exception $e) {
            return $response->withStatus($e->getCode())->write($e->getMessage());
        }
    }

Same as in the `create()` method, the `save()` will return the object in case it succeeds to update and throw any error sent from the API


**Deleting objects**

Call the `Ivanwitzke\Agendor\<Object>::delete($id)` method.

*Example:*

    $response = Ivanwitzke\Agendor\Task::delete($taskId);

It returns `true` if successful and throws the errors send from the API
