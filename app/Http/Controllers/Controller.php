<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


	public function show() {
		return view('main');
	}

	public function process_matches(Request $request) {

		$matches = $this->match_participants($request->input('groups'));

		return response()->json($matches);
	}

	private function match_participants($participants)
	{
		$recipients = $participants;

		$matches = [];

		$i = 0;

		for ($gg = 0; $gg < count($participants); $gg++) {

			for ($g = 0; $g < count($participants[$gg]); $g++) {

				$rg = $gg;
				while ($rg === $gg) {
					$rg = array_rand($recipients);
				}

				$r = array_rand($recipients[$rg]);


				//clock("$gg - $g | $rg - $r");

				$matches[] = [
					//gifter
					$participants[$gg][$g],
					//recepient
					$participants[$rg][$r]
				];

				unset($recipients[$rg][$r]);

				if (!count($recipients[$rg])) {
					unset($recipients[$rg]);
				}

				//clock(++$i);
			}


		}

		return $matches;
	}
}

// $groups = [ // p == participants
// 	[
// 		'Nolan',
// 		'Esther'
// 	],
// 	[
// 		'Scott',
// 		'Holly'
// 	],
// 	[
// 		'Ian',
// 		'Marianne'
// 	],
// 	[
// 		'Wayne',
// 		'Megan'
// 	],
// 	[
// 		'Mike',
// 		'Kelly'
// 	],
// 	[
// 		'Janelle'
// 	]
// ];
