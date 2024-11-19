<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, DELETE, PATCH, POST");
header("Access-Control-Allow-Headers: Content-Type");


$host = 'localhost';
$dbname = 'crm';
$user = 'root';
$password = '';


  
 /*  
this is my table:

id INT
active TINYINT
name VARCHAR(500)|
surname VARCHAR(500)|
Z
subject_id INT
source VARCHAR(500)|
date_of_contract DATE
date_of_2_contract DATE
date_of_meeting DATE
result VARCHAR(500)
workshop VARCHAR(500)
brigade VARCHAR(500)
practice VARCHAR(500)
cv TINYINT
note VARCHAR (500)

*/

/* my rest api
/firms/list	get
/firms/save	post
/firms/update	patch
/firms/remove	delete
 */


//list
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'list') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('SELECT * FROM firms');
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
                exit;
            }
        }
        break;

//save
    case 'POST':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'save') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('INSERT INTO firms (active, name, surname, subject_id, source, date_of_contract, date_of_2_contract, date_of_meeting, result, workshop, brigade, practice, cv, note) VALUES (:active, :name, :surname, :subject_id, :source, :date_of_contract, :date_of_2_contract, :date_of_meeting, :result, :workshop, :brigade, :practice, :cv, :note)');
                $stmt->execute($_POST);
                echo json_encode(array('id' => $db->lastInsertId()));
                exit;
            }
        }
        break;

//update
    case 'PATCH':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'update') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('UPDATE firms SET active = :active, name = :name, surname = :surname, subject_id = :subject_id, source = :source, date_of_contract = :date_of_contract, date_of_2_contract = :date_of_2_contract, date_of_meeting = :date_of_meeting, result = :result, workshop = :workshop, brigade = :brigade, practice = :practice, cv = :cv, note = :note WHERE id = :id');
                $stmt->execute($_POST);
                echo json_encode(array('id' => $_POST['id']));
                exit;
            }
        }
        break;

//delete
    case 'DELETE':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'remove') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('DELETE FROM firms WHERE id = :id');
                $stmt->execute(array('id' => $url[2]));
                exit;
            }
        }
        break;


/*my 2nd table:
id INT
firm_id INT
main INT
active_c TINYINT
name VARCHAR(500)
surname VARCHAR(500)
email VARCHAR(500)
phone VARCHAR(14)
vokativ VARCHAR (100)
*/


/* my 2nd rest api:
/firms/contact/save	post
/firms/contact/update	patch
/firms/contact/remove	delete
 */


//save
    case 'POST':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'contact' && $url[2] == 'save') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('INSERT INTO contacts (firm_id, main, active_c, name, surname, email, phone, vokativ) VALUES (:firm_id, :main, :active_c, :name, :surname, :email, :phone, :vokativ)');
                $stmt->execute($_POST);
                echo json_encode(array('id' => $db->lastInsertId()));
                exit;
            }
        }
        break;

//update
    case 'PATCH':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'contact' && $url[2] == 'update') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('UPDATE contacts SET firm_id = :firm_id, main = :main, active_c = :active_c, name = :name, surname = :surname, email = :email, phone = :phone, vokativ = :vokativ WHERE id = :id');
                $stmt->execute($_POST);
                echo json_encode(array('id' => $_POST['id']));
                exit;
            }
        }
        break;

//delete
    case 'DELETE':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'contact' && $url[2] == 'remove') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('DELETE FROM contacts WHERE id = :id');
                $stmt->execute(array('id' => $url[3]));
                exit;
            }
        }
        break;
    
/*this is my 3rd table:

id INT
firm_id INT
path VARCHAR(500)

*/

/*my 3rd rest api:
/firms/card/list	get
/firms/card/save	post
/firms/card/update	patch
/firms/card/delete	delete
 */

    
    //list
    case 'GET':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'card' && $url[2] == 'list') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('SELECT id, firm_id, path FROM cards WHERE firm_id = :firm_id');
                $stmt->execute(array('firm_id' => $url[3]));
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
                exit;
            }
        }
        break;

    //save
    case 'POST':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'card' && $url[2] == 'save') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('INSERT INTO cards (firm_id, path) VALUES (:firm_id, :path)');
                $stmt->execute(array(
                    'firm_id' => $url[3],
                    'path' => $_POST['path']
                ));
                echo json_encode(array('id' => $db->lastInsertId()));
                exit;
            }
        }
        break;

    //update
    case 'PATCH':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'card' && $url[2] == 'update') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('UPDATE cards SET firm_id = :firm_id, path = :path WHERE id = :id');
                $stmt->execute(array(
                    'firm_id' => $url[3],
                    'path' => $_POST['path'],
                    'id' => $_POST['id']
                ));
                echo json_encode(array('id' => $_POST['id']));
                exit;
            }
        }
        break;

    //delete
    case 'DELETE':
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if ($url[0] == 'firms' && $url[1] == 'card' && $url[2] == 'remove') {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
                $stmt = $db->prepare('DELETE FROM cards WHERE id = :id');
                $stmt->execute(array('id' => $url[3]));
                exit;
            }
        }
        break;
    }
