<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <table>
    <tr>
      <th>Namn</th>
      <th>Betalat</th>
      <th>Veckans påse</th>
      <th>E-mail</th>
      <th>Adress</th>
      <th>Mobiltelefon</th>
      <th>Matpreferenser</th>
      <th>Intervall</th>
    </tr>
    @foreach($users as $user)
    <tr>
      <td>{{ $user->name }}</td>
      <td>@if($user->payed) Betalat @else Inte betalat @endif</td>
      <td>{{ $user->currentDinner }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->street.', '.$user->postalCode.', '.$user->city }}</td>
      <td>{{ $user->telephoneNumber }}</td>
      <td>{{ $user->additionalInfo }}</td>
      <td>{{ \App\User::intervalClearText(($user->interval)) }}</td>
    </tr>
    @endforeach
  </table>
</body>
</html>
