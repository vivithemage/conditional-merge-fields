<?php
  /*
  {IFFIELD[FIELDNAME][CRITERIA] The content to include if the IF passes would go here}

  e.g.

  {IFFIELD[accountshipads_street][notempty] Street: $accountshipads_street}
  A cool extension of this (but may not be needed for the jet hire project) would be the ability to also check what the value is e.g.

  {IFFIELD[quotes_total][>1000000000000] Wowsers, this is a big quote!! } 
  */
  $html = "sdfjalsdjf sdfjlksd fsdj {IFFIELD[accountshipads_street][notempty] Street: \$accountshipads_street} jsdfkjaksldfjlsdfjl dsjf jlsfds \n";
  echo $html;
  
  $pattern = "/{IFFIELD\[/";
  echo $pattern;
  
  if (preg_match($pattern,$html)) {
    echo "\nMatch\n";
  }
  else  {
    echo "\nNot match\n";
  }
?>
