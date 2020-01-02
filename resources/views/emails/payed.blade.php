<h1>Vecka {{ date('W' )}} betalade kunder</h1>
@foreach($users as $user)
<hr>
<p><b>Namn</b>  {{ $user->name }}</p>
<p><b>E-mail</b>  {{ $user->email }} </p>
<p><b>Address</b>  {{ $user->street . ', ' . $user->postalCode . ', ' . $user->city }} </p>
<p><b>Mobiltelefon</b>  {{ $user->telephoneNumber }}</p>
<p><b>Matpreferenser</b>  {{ $user->additionalInfo }}</p>
<p><b>Extra produkter</b>  {{ $user->extraProductNext }}</p>
<p><b>Intervall</b> {{ \App\User::intervalClearText(($user->interval)) }} veckan</p>
@if(!empty($user->dinnerProductAlternative))
<p><b>Veckans alternativa påse</b> {{ $user->dinnerProductAlternative }}</p>
<p><b>Betalat</b> {{ $user->extraProductPrice+$user->dinnerProductAlternativePrice }} SEK</p>
@else
<p><b>Veckans påse</b> {{ $user->dinnerProduct }}</p>
<p><b>Betalat</b> {{ $user->extraProductPrice+$user->dinnerProductPrice }} SEK</p>
@endif
<p><b>Antal påsar</b>  {{ $user->dinnerProductAmount }}</p>
@endforeach