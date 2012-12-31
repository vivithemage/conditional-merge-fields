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
    2. How do you allow for any characters other than say one, e.g. all characters except } - need to allow for any character including {}.
  */

  // Processing if the pdf function starts with IFFIELD
  function pdftemplate_function_iffield($html, $matches)  {
      // pick out the variables in the pdf function
      // TODO: Allow for any characters in content
      $pattern = "/\{[IFFIELD]*\[(?P<function_variables>[\w&$]*)\]\[(?P<specifics>[\w]*)\](?P<content>[^{}]*)\}/";
      preg_match($pattern,$matches, $components_array);
      print_r($components_array);

      // TODO: Put in loop here to allow for multiple function specifics, variables splitting in this loop.
      // Check variables are not empty
      if ($components_array['specifics'] == "notempty")  {
        echo "  > In notempty\n";
        // Split function variables here. & seems like a good delimeter, explode it and then loop through checking if any of these values are empty
        $function_variables_array = explode('&', $components_array['function_variables']);
        // Cycle through array for variable checking.
        foreach ($function_variables_array as &$value) {
            echo "Looking up merge variable: $value \n";
            // TODO: look up the variable value and check if it's empty. if it's not empty, use the
            $ret_var_val = '';
            if (empty($ret_var_val))   {
                $var_is_empty = false;
                break;
            }
        }
        // value is empty, do don't display anything otherwise echo out the content
        if ($var_is_empty != true) { $replacement = $components_array['content']; } else { $replacement = ''; }
      }
      // if the start character of $components_array['specifics'] is an operator, <, >...

      // Replacing the pdf template function with results
        echo $replacement;
      $html = str_replace($components_array[0], $replacement, $html);
      //echo "here : $html\n";
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
  $html = 'sdfds {IFFIELD[$accountshipads_street&$puddingwoe][notempty]ca ccountshipadsstreet noii} endingszwoes ';
  $html .= "sdfds {IFCONTAINS[accountshipads_street][pudding street]ndf}";
  $html .= "sdxwsdwefds {IFFIELD[first_name][>100000]Bigzz}\n";
  echo "Before running pdftemplate_functions: ".$html;

  $pattern = "/\{[A-Z]*\[[\w&$]*\]\[[\w]*\][\s\S]*\}/";
  echo "Regex pattern: ".$pattern;

  if (preg_match($pattern,$html,$matches)) {
    echo "\nInitial match to pdf function structure\n";
    //print_r($matches);
    $found_match = $matches[0];
    echo $found_match;
    $html_complete = pdftemplate_functions($html,$found_match);
    echo "After running pdftemplate_functions: ".$html_complete;
  }
  else  {
    //TODO Change all these echo's to log instead
    echo "No Functions within pdf template found\n";
  }
?>
