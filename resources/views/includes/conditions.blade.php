<hr>
@for($i = 5; $i < 16; $i++)
<div class="h4">
  <b>
    {!! $texts[$i]->title !!}
  </b>
</div>
<p>
  {!! $texts[$i]->text !!}
</p>
<br>
@endfor
<hr>
