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
				var parId = sendId.replace('-fd--', '-');
				var parentSubmit = document.getElementById(parId);
				if (parentSubmit !== null)
				{
					var subId = sendId.replace('-fd--', '-fs--');
					var chapterSubmit = document.getElementById(subId);
					if (chapterSubmit !== null)
					{
						var leftSubmit = (sender.offsetLeft
										- parentSubmit.offsetLeft
										- chapterSubmit.clientWidth
										+ sender.clientWidth);
						if (leftSubmit < 0) { leftSubmit = 0; }
						// Apply the new relative location...
						chapterSubmit.style.left = leftSubmit + "px";
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

// -------------------------------------
// ----------- TINY M C E --------------

function tiny_initialize(htmlContent = null)
{
	//Load content...
	if (htmlContent !== null)
	{
		var edPart = document.getElementById("editable-part");
		if (edPart !== null)
		{
			edPart.innerHTML = htmlContent;
		}
	}

	//Initialize MCE...
	tinymce.init(
	{
		selector: '#editable-part',
		language : "fr_FR",
		branding: false
	});
}

function chapterSubmit()
{
	//From chapter...
	selectedSubmit(true);
}

function selectedSubmit(fromChapter = false)
{
	var selEdit = document.getElementById("sel-edit");
	if (selEdit !== null)
	{
		//Chapter case: no part data (default: new)
		if (fromChapter)
		{
			var pSel = document.getElementById("part-selector");
			if (pSel !== null)
			{
				pSel.value = "new";
			}
		}

		//Submit the GET form...
		selEdit.submit();
	}
}

function getContentToSubmit()
{
	var TinyOutput = document.getElementById("hidden-part");
	if (TinyOutput !== null)
	{
		//Report the tiny content in the form component...
		TinyOutput.value = tinymce.activeEditor.getContent();
	}
}

function confirmBeforeSubmit()
{
	if (new RegExp("&part=[0-9]+").test(window.location))
	{
		if (confirm("Voulez-vous vraiment supprimer cet épisode (irréversible) ?"))
		{
			var partDelete = document.getElementById("part-delete");
			if (partDelete !== null)
			{
				var pattern = /author\.manage-parts\?chapter=.*&part=/g;
				var root = pattern.exec(window.location);
				partDelete.action = root + "new";
				partDelete.submit();
			}
			partDelete = null;
		}
	}
	else if (confirm("Voulez-vous vraiment abandonner cet épisode (non enregistré) ?"))
	{
		window.location.reload();
	}
}

// -------------------------------------
// -------------------------------------