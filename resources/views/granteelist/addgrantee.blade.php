<form action="{{ route('grantee_list.store') }}" method="POST">
@csrf

<input type="number" name="seq" placeholder="Sequence">

<input type="text" name="last_name" placeholder="Last Name">

<input type="text" name="first_name" placeholder="First Name">

<input type="text" name="extension_name" placeholder="Extension">

<input type="text" name="mobile_number" placeholder="Mobile">

<input type="email" name="email" placeholder="Email">

<input type="text" name="course" placeholder="Course">

<input type="number" name="year" placeholder="Year">

<input type="number" name="years_of_stay" placeholder="Years of Stay">

<select name="status">
<option>Enrolled</option>
<option>Graduated</option>
<option>Shifted</option>
<option>Transferred</option>
</select>

<textarea name="remarks"></textarea>

<button type="submit">Save</button>

</form>