<?php
$sql = $db->query("SELECT * FROM $_SESSION[prefix]_globals WHERE id = 1");
$org = $sql->fetch(PDO::FETCH_ASSOC);
$state_list = ARRAY(
	'AL'=>"Alabama",
    'AK'=>"Alaska", 
    'AZ'=>"Arizona", 
    'AR'=>"Arkansas", 
    'CA'=>"California", 
    'CO'=>"Colorado", 
    'CT'=>"Connecticut", 
    'DE'=>"Delaware", 
    'DC'=>"District Of Columbia", 
    'FL'=>"Florida", 
    'GA'=>"Georgia", 
    'HI'=>"Hawaii", 
    'ID'=>"Idaho", 
    'IL'=>"Illinois", 
    'IN'=>"Indiana", 
    'IA'=>"Iowa", 
    'KS'=>"Kansas", 
    'KY'=>"Kentucky", 
    'LA'=>"Louisiana", 
    'ME'=>"Maine", 
    'MD'=>"Maryland", 
    'MA'=>"Massachusetts", 
    'MI'=>"Michigan", 
    'MN'=>"Minnesota", 
    'MS'=>"Mississippi", 
    'MO'=>"Missouri", 
    'MT'=>"Montana",
    'NE'=>"Nebraska",
    'NV'=>"Nevada",
    'NH'=>"New Hampshire",
    'NJ'=>"New Jersey",
    'NM'=>"New Mexico",
    'NY'=>"New York",
    'NC'=>"North Carolina",
    'ND'=>"North Dakota",
    'OH'=>"Ohio", 
    'OK'=>"Oklahoma", 
    'OR'=>"Oregon", 
    'PA'=>"Pennsylvania", 
    'RI'=>"Rhode Island", 
    'SC'=>"South Carolina", 
    'SD'=>"South Dakota",
    'TN'=>"Tennessee", 
    'TX'=>"Texas", 
    'UT'=>"Utah", 
    'VT'=>"Vermont", 
    'VA'=>"Virginia", 
    'WA'=>"Washington", 
    'WV'=>"West Virginia", 
    'WI'=>"Wisconsin", 
    'WY'=>"Wyoming");
?>
<div class="row">
<div class="col-md-12">
<div class="card-deck">

<div class="card mb-4">
<div class="card-body">
<div class="md-form">
<input type="text" class="form-control" name="orgname" id="orgname" value="<?php echo $org['site_name'] ?>" onchange="submitForm('sitename', 9, this.value)" />
<label for="orgname">Organization's Name</label>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<div class="md-form">
<input type="text" class="form-control" name="address" id="address" value="<?php echo $org['address'] ?>" onchange="submitForm('address', 9, this.value)" />
<label for="address">Organization's Address</label>
</div>
<div class="md-form">
<input type="text" class="form-control" name="city" id="city" value="<?php echo $org['city'] ?>" onchange="submitForm('city', 9, this.value)" />
<label for="city">City</label>
</div>
<div>
<label for="state">State</label>
<select class="mdb-select md-form colorful-select dropdown-primary initialized" searchable="Search here.." name="state" id="state" onchange="submitForm('state', 9, this.value)">
<option disabled value="">Select</option>
<?php
foreach($state_list AS $value => $name) {
     if($name == $org['state']) {
          echo '<option value="'. $name .'" selected="selected">'. $name .'</option>';
     } else {
          echo '<option value="'. $name .'">'. $name .'</option>';          
     }
}
?>
</select>
</div>
<div class="md-form">
<input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo $org['zip_code'] ?>" onchange="submitForm('zipcode', 9, this.value)" />
<label for="zipcode">Zipcode</label>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<div class="md-form">
<input type="text" class="form-control" name="phone" id="phone" value="<?php echo $org['phone'] ?>" onchange="submitForm('phone', 9, this.value)" />
<label for="phone">Phone Number</label>
<small class="form-text text-muted">Numbers only.  Site will snazzy it up later.</small>
</div>
<div class="md-form">
<input type="text" class="form-control" name="email" id="email" value="<?php echo $org['email_address'] ?>" onchange="submitForm('email', 9, this.value)" />
<label for="email">Email Address</label>
<small class="form-text text-muted">This is the email address used on contact forms, and displayed on other areas.</small>
</div>
<div class="md-form">
<input type="text" class="form-control" name="emailtext" id="emailtext" value="<?php echo $org['email_text'] ?>" onchange="submitForm('emailtext', 9, this.value)" />
<label for="emailtext">Email Text</label>
<small class="form-text text-muted">Text that shows instead of email address to help hide/mask the Email (from spammers).</small>
</div>

</div>
</div>
</div>
</div>
</div>

