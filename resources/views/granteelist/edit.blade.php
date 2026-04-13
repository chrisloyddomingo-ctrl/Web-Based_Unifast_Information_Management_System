<h2>Edit Grantee</h2>

<form action="{{ route('grantee_list.update', $grantee->id) }}" method="POST">
@csrf
@method('PUT')

<input type="text" name="last_name" value="{{ $grantee->last_name }}">
<input type="text" name="first_name" value="{{ $grantee->first_name }}">
<input type="text" name="extension_name" value="{{ $grantee->extension_name }}">

<input type="text" name="mobile_number" value="{{ $grantee->mobile_number }}">
<input type="email" name="email" value="{{ $grantee->email }}">

<input type="text" name="course" value="{{ $grantee->course }}">
<input type="number" name="year" value="{{ $grantee->year }}">
<input type="number" name="years_of_stay" value="{{ $grantee->years_of_stay }}">

<select name="status">
<option {{ $grantee->status == 'Enrolled' ? 'selected' : '' }}>Enrolled</option>
<option {{ $grantee->status == 'Graduated' ? 'selected' : '' }}>Graduated</option>
<option {{ $grantee->status == 'Shifted' ? 'selected' : '' }}>Shifted</option>
<option {{ $grantee->status == 'Transferred' ? 'selected' : '' }}>Transferred</option>
</select>

<textarea name="remarks">{{ $grantee->remarks }}</textarea>

<button type="submit">Update</button>

</form>