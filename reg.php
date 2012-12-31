<?php
  /*
  Specification.

    {IFFIELD[FIELDNAME][CRITERIA] The content to include if the IF passes would go here}

    e.g.

    {IFFIELD[accountshipads_street][notempty] Street: $accountshipads_street}
    A cool extension of this (but may not be needed for the jet hire project) would be the ability to also check what the value is e.g.

    {IFFIELD[quotes_total][>1000000000000] Wowsers, this is a big quote!! }

  Questions
    1. How the hell do you replace stuff, as in remove the iffield and replace with a var for example - looks like preg_replace may do the trick
    2. How do you allow for any characters other than say one, e.g. all characters except }
  */

  function pdftemplate_function_iffield($html, $matches)  {
      // pick out the variables in the pdf function
      // TODO: Allow for any characters in content
      $pattern = "/\{[IFFIELD]*\[(?P<function_variables>[\w&$]*)\]\[(?P<specifics>[\w]*)\](?P<content>[\w]*)\}/";
      preg_match($pattern,$matches, $components_array);
      print_r($components_array);

      // TODO: Put in loop here to allow for multiple function specifics, variables splitting in this loop.
      // Check variables are not empty
      if ($components_array['specifics'] == "notempty")  {
        echo "  > In notempty\n";
        // Split function variables here. & seems like a good delimeter, explode it and then loop through checking if any of these values are empty
        var_dump(explode('&', $components_array['function_variables']));
        // sql for checking
      }

      // if the start character of $components_array['specifics'] is an operator, <, >

      // Replacing function with function results
      $replacement = "OOf";
      $html = str_replace($matches, $replacement, $html);
      return $html;
  }

  // Parse the pdftemplate and do any needed processing, then replace
  function pdftemplate_functions($html,$matches) {
    $root_pdftemplate_funct = array ('iffield_pattern' => "/^\{IFFIELD/",
                                     'ifother_pattern' => "/^\{IFOTHER/");

    // For the IFFIELD function
    if (preg_match($root_pdftemplate_funct['iffield_pattern'], $matches, $match_within)) {
      echo "Matched IFFIELD, processing... \n";
      $html = pdftemplate_function_iffield($html, $matches);
    }
    // For the IFOTHER function
    else  if (preg_match($root_pdftemplate_funct['ifother_pattern'], $matches, $match_within)) {
      echo "Matched IFOTHER, processing... \n";
      // nothing for this yet.
    }
    return $html;
  }

  // main
  $html = 'sdfds {IFFIELD[$accountshipads_street&$puddingwoe][notempty]caccountshipadsstreet} endingszwoes ';
  $html .= "sdfds {IFCONTAINS[accountshipads_street][pudding street]ndf}";
  $html .= "sdxwsdwefds {IFFIELD[first_name][>100000]Bigzz}\n";
  echo "Before: ".$html;

  $pattern = "/\{[A-Z]*\[[\w&$]*\]\[[\w]*\][\w]*\}/";
  echo "Regex pattern: ".$pattern;

  if (preg_match($pattern,$html,$matches)) {
    echo "\nMatch\n";
    //print_r($matches);
    $found_match = $matches[0];
    echo $found_match;
    $html_complete = pdftemplate_functions($html,$found_match);
    echo "After: ".$html_complete;
  }
  else  {
    echo "No Functions within pdf template found\n";
  }
?>
