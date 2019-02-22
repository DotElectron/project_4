// --------------------------
// --------------------------
// Admin: switch chapters (forms)...
function switch_adm_chapter(e)
{
	//Visbility of...
	if (!e) { e = window.event; }
	var sender = e.srcElement || e.target || e;
	if (sender !== null) 
	{ 
		var sendId = sender.id.replace('-i--', '-f--')
							  .replace('-s--', '-f--')
							  .replace('-d--', '-fd--'); 
	}
	var chapterForm = document.getElementById(sendId);
	if (chapterForm !== null)
	{
		if (chapterForm.style.display === ""
			|| chapterForm.style.display === "none")
		{
			chapterForm.style.display = "block";
			if (sendId.includes('-fd--'))
			{
				// Extra job: left position...
				var ParId = sendId.replace('-fd--', '-');
				var parentSubmit = document.getElementById(ParId);
				if (parentSubmit !== null)
				{
					var SubId = sendId.replace('-fd--', '-fs--');
					var chapterSubmit = document.getElementById(SubId);
					if (chapterSubmit !== null)
					{
						var LeftSubmit = (sender.offsetLeft
										- parentSubmit.offsetLeft
										- chapterSubmit.clientWidth
										+ sender.clientWidth);
						if (LeftSubmit < 0) { LeftSubmit = 0; }
						// Apply the new relative location...
						chapterSubmit.style.left = LeftSubmit + "px";
					}
				}
			}
		}
		else
		{
			chapterForm.style.display = "none";
		}
		// hasAction(sendId);
		resetActions(sendId);
		chapterForm = null;
	}
	sendId = null;
	sender = null;
	e = null;
}

// function hasAction(sender)
// {
// 	//Applied only on identified components (forms)
// 	var altSendId = null;
// 	if (sender.includes('-f--')) 
// 	{
// 		altSendId = sender.replace('-f--', '-fd--');
// 	}
// 	else if (sender.includes('-fd--')) 
// 	{
// 		altSendId = sender.replace('-fd--', '-f--');
// 	}
// 	var altSender = document.getElementById(altSendId);
// 	if (altSender !== null)
// 	{
// 		if (altSender.style.display = "block")
// 		{
// 			altSender.style.display = "none";
// 		}
// 		altSender = null;
// 	}
// 	altSendId = null;
// }

function resetActions(senderId)
{
	//Applied on all taggued components: 'chap-tag' (forms) [except sender]
	for (let chapi of document.getElementsByClassName('chap-tag'))
	{
		if (chapi.id !== senderId)
		{
			chapi.style.display = "none";
		}
	}
}

function switch_adm_toNewChap()
{
	var chapSource = document.getElementById("chap-s--new-chap");
	if (chapSource !== null)
	{
		switch_adm_chapter(chapSource);
		chapSource = null;
	}
}