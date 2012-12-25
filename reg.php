<?php
  /*
  {IFFIELD[FIELDNAME][CRITERIA] The content to include if the IF passes would go here}

  e.g.

  {IFFIELD[accountshipads_street][notempty] Street: $accountshipads_street}
  A cool extension of this (but may not be needed for the jet hire project) would be the ability to also check what the value is e.g.

  {IFFIELD[quotes_total][>1000000000000] Wowsers, this is a big quote!! } 
  */

  /* Questions
    How the hell do you replace stuff, as in remove the iffield and replace with a var for example - looks like preg_replace may do the trick

  How do you allow for any characters other than say one, e.g. all characters except } */

  // Parse the pdftemplate and do any needed processing, then replace
  function pdftemplate_functions($html,$matches) {
    $iffield_pattern = "/^\{IFFIELD/";
    $ifcount_pattern = "/^\{IFCOUNT/";
   
    // For the IFFIELD function 
    if (preg_match($iffield_pattern, $matches, $match_within)) {
      echo "\ninside match IFFIELD \n";
    } 
    
    // For the IFCOUNT function 
    if (preg_match($iffield_pattern, $matches, $match_within)) {
      echo "\ninside match IFCOUNT\n";
    }
    return $html;   
  }

  $html = "sdfds {IFFIELD[accountshipads_street][notempty]ndf}";
  $html .= "sdfds {IFCONTAINS[accountshipads_street][pudding street]ndf}";
  $html .= "sdxwsdwefds {IFFIELD[first_name][>100000]Bigzz}";
  echo 'before: '.$html;
  
  $pattern = "/\{[A-Z]*\[[\w]*\]\[[\w]*\][\w]*\}/";
  echo $pattern;
  
  if (preg_match($pattern,$html,$matches)) {
    echo "\nMatch\n";
    //print_r($matches);
    $found_match = $matches[0];
    echo $found_match.'\n';
    $html_complete = pdftemplate_functions($html,$found_match); 
  }
  else  {
    echo "\nNo match\n";
  }
  
  echo 'end result: '.$html_complete;
?>
