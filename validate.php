<?php
//echo "hello world";

$guid = isset($_GET['guid']) ? $_GET['guid'] : null;

if (empty($guid)) {
    echo "{'error':1,'message':'wrong guid'}";
    exit;
}

require_once 'class.model.php';

$file = new Files();
$result = $file->get($guid);

//print_r ($result['file_name']);

if (!empty($result)) {
    $extension = strtolower(pathinfo($result['file_name'], PATHINFO_EXTENSION));
    //print_r ($extension);
}
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$request = new Requests();

$result = $request->getEmails($guid);

if (empty($result) || $result === true) {
    echo "{'error':1,'message':'no validate data in excel as its format probably is wrong}";
    exit;
}

$emails = array();
foreach ($result as $value) {
    $emails[] = trim($value['request_email']);
}

$emails = array_unique($emails);
$data = array();

foreach ($emails as $email) {
    $data[$email] = $request->getRequestsByEmail($email, $guid);
}

$valid = array();
$invalid = array();
foreach ($data as $key => $value) {

    if (validEmail($key) == false) {
        $invalid[$key] = $value;
    } else {
        $valid[$key] = $value;
    }
}

/**
  Validate an email address.
  Provide email address (raw input)
  Returns true if the email address has the email
  address format and the domain exists.
 */
function validEmail($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex + 1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        } else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        } else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        } else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        } else if
        (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
            // character not valid in local part unless 
            // local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}
?>
<h3>Below Messages Ready to Send:</h3>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Email</th>
            <th>Company</th>
            <th>Contact</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($valid as $key => $values) : ?>
        <tr style="background-color:white;"><td colspan="4"><b><?php echo $key; ?></b></td></tr>
        <?php foreach ($values as $value) : ?>
            <tr>
                <td><input type="checkbox" name="selected[]" value='<?php echo $value['request_guid']; ?>' /></td>
                <td></td>
                <td><?php echo $value['request_company']; ?></td>
                <td><?php echo $value['request_contact_person']; ?></td>
            </tr>
    <?php endforeach;            endforeach;?>
    </tbody>
</table>
<hr/>
<?php
if (!empty ($invalid)) : ?>
<h3>Below Email Addresses are not valid, Please check and upload spreadsheet again:</h3>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Email</th>
            <th>Company</th>
            <th>Contact</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($invalid as $key => $values) : ?>
        <tr style="background-color:white;"><td colspan="4"><b><?php echo $key; ?></b></td></tr> 
    <?php foreach ($values as $value) : ?>
            <tr>
                <td>At Row <?php echo $value['request_row']; ?> In Your File</td>
                <td><?php echo $value['request_email']; ?></td>
                <td><?php echo $value['request_company']; ?></td>
                <td><?php echo $value['request_contact_person']; ?></td>
            </tr>
    <?php endforeach;                            endforeach;?>
    </tbody>
</table>
<?php endif; ?>
 
