<?php
		//test user input to help prevent HTML injection
		function test_input($data){ # this function will return true if it receives a valid input
		    $original = $data;
			
			/*convert 5 predefined characters into HTML values.		
			 They are > (&gt;), < (%lt;), " (&quot;), ' (&#039;), & (&amp;)   */			
			$data = htmlspecialchars($data);

			//check for possible html injection
			if ($data === $original) return true;
            else return ("Attempted HTML injection:    $data");
		}
		

?>