// --------------------------
// --------------------------
// AJAX: particular ASYNC treatment...

var ajaxCat = 
{
	// Ajax command...
	AddAlert: 1,
	RemAlert: 2,
	AddBan: 3,
	RemBan: 4,
	properties: 
	{
		1: 
	  	{
			name: "Add_Alert_Comment", 
			code: "ajax-redir--user_comm-alert",
			action: "userAlert=true&userIdentifier="
		},
		2: 
	  	{
			name: "Remove_Alert_Comment", 
			code: "ajax-redir--user_comm-alert",
			action: "userAlert=false&userIdentifier="
		},
		3: 
	  	{
			name: "Add_Ban_Comment", 
			code: "ajax-redir--admin_comm-ban",
			action: "adminBan=true&adminIdentifier="
		},
		4: 
	  	{
			name: "Remove_Ban_Comment", 
			code: "ajax-redir--admin_comm-ban",
			action: "adminBan=false&adminIdentifier="
		}
	}
};

function ajaxMasterTreatment(senderCat, sendValue)
{
	// Generic treatment based on commands...
	var job = new XMLHttpRequest();
	job.open("POST", ajaxCat.properties[senderCat].code, true); 
	job.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	job.onreadystatechange =
		function() 
		{
			if (job.readyState === 4)		//4:loaded | 3:header_received
			{
				var report = document.getElementById('last-debug');
				if (report !== null)
				{
					if (job.status < 200 && job.status >= 400) 
					{
						//Error...
						report.innerHTML += "Erreur interne : [" 
							+ ajaxCat.properties[senderCat].name + "]" 
							+ job.status + " " + job.statusText;
					}
					else
					{
						// Successfull...
						report.innerHTML += job.responseText;
					}
					report.style.display = "flex";
				}
			}
		};
	job.send(ajaxCat.properties[senderCat].action + sendValue);
}

// -------------------------------------
// -------------------------------------

function ajaxSendAlertOnComment(commId)
{
	//Update comment with a positive flag...
	ajaxMasterTreatment(ajaxCat.AddAlert, commId);
}

function ajaxRemAlertOnComment(commId)
{
	//Update comment with a negative flag...
	ajaxMasterTreatment(ajaxCat.RemAlert, commId);
}

// -------------------

function ajaxSendBanOnComment(commId)
{
	//Update comment with a positive mute state...
	ajaxMasterTreatment(ajaxCat.AddBan, commId);
}

function ajaxRemBanOnComment(commId)
{
	//Update comment with a negative mute state...
	ajaxMasterTreatment(ajaxCat.RemBan, commId);
}

// -------------------------------------
// -------------------------------------