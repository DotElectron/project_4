// --------------------------
// --------------------------
// User: prepare an action on a comment...

function expandComments(e)
{
	//Visbility of...
	if (!e) { e = window.event; }
	var sender = e.srcElement || e.target;
	if (sender !== null) 
	{ 
		var sendId = sender.id.replace('-i--', '-d--'); 
		var blockComment = document.getElementById(sendId);
		if (blockComment !== null)
		{
			if (blockComment.style.display === ""
				|| blockComment.style.display === "none")
			{
				blockComment.style.display = "block";
				sender.className = "fas fa-2x fa-angle-double-up";
			}
			else
			{
				blockComment.style.display = "none";
				sender.className = "fas fa-2x fa-angle-double-down";
			}
			usrResetActions(sendId);
			blockComment = null;
		}
	}
}

function usrResetActions(senderId)
{
	//Applied on all taggued components: 'part-tag' (div) [except sender]
	for (let iPart of document.getElementsByClassName('part-tag'))
	{
		if (iPart.id !== senderId
			&& iPart.style.display === "block")
		{
			iPart.style.display = "none";
			var blockId = iPart.id.replace('-d--', '-i--'); 
			var blockComment = document.getElementById(blockId);
			if (blockComment !== null)
			{
				blockComment.className = "fas fa-2x fa-angle-double-down";
			}
			blockComment = null;
			blockId = null;
		}
	}
}

// -------------------------------------
// -------------------------------------

function submitComment(e)
{
	if (!e) { e = window.event; }
	var sender = e.srcElement || e.target;
	if (sender !== null) 
	{ 
		var sendId = sender.id.replace('-s--', '-f--'); 
		var formComment = document.getElementById(sendId);
		if (formComment !== null)
		{
			sendId = sender.id.replace('-s--', '-t--'); 
			var sourceComment = document.getElementById(sendId);
			if (sourceComment !== null)
			{
				sendId = sender.id.replace('-s--', '-l--'); 
				var AlertComment = document.getElementById(sendId);
				if (sourceComment.value !== "")
				{
					sendId = sender.id.replace('-s--', '-c--'); 
					var textComment = document.getElementById(sendId);
					if (textComment !== null)
					{
						//Reaffect value...
						textComment.value = sourceComment.value;
						//Submit the POST form...
						formComment.submit();
						//Clean user alert...
						if (AlertComment !== null)
						{
							AlertComment.style.display = "none";
							AlertComment = null;
						}
					}
				}
				else
				{
					if (AlertComment !== null)
					{
						AlertComment.style.display = "block";
						AlertComment = null;
					}
				}
				sourceComment = null;	
			}
			formComment = null;
		}
	}
}