// --------------------------
// --------------------------
// Body Adjustement (multi-jobs)
function body_adjustement()
{
	// Main replacement (margin-top)...
	var winLocStr = window.location.toString();
	var topContList = document.getElementsByTagName('header');
	var mainContList = document.getElementsByTagName('main');
	if ((topContList.length > 0 && topContList[0] !== null)
		&& (mainContList.length > 0 && mainContList[0] !== null))
	{
		topContainer = topContList[0];
		mainContainer = mainContList[0];
		mainContainer.style.marginTop = topContainer.clientHeight + "px";
		topContainer = null;
		mainContainer = null;
	}
	topContList = null;
	mainContList = null;

	// Debug visibility...
	var test = document.getElementById('last-debug');
	if (test !== null)
	{
		if (test.childNodes.length < 2)
		{
			test.style.display = "none";
		}
		else
		{
			test.style.display = "flex";
		}
	}

	// Comments area visibility...
	var winLocStr = window.location.toString();
	if (winLocStr.includes("#comments-"))
	{
		//Get the current ordered component...
		var idx = winLocStr.indexOf("#comments-");
		var id = winLocStr.substring((idx + 10));

		//Transform the current to update his visbility...
		var blockId = "com-d--" + id; 
		var blockComment = document.getElementById(blockId);
		if (blockComment !== null)
		{
			var iconId = "com-i--" + id; 
			var iconComment = document.getElementById(iconId);
			if (blockComment.style.display === ""
				|| blockComment.style.display === "none")
			{
				blockComment.style.display = "block";
				if (iconComment !== null)
				{
					iconComment.className = "fas fa-2x fa-angle-double-up";
				}
				iconComment = null;
			}
			blockComment = null;
		}
	}

	// Comm'alerts from user cookies...
	var commList = document.getElementsByClassName("comm-tag");
	for (let comm of commList)
	{
		if (document.cookie.includes(comm.id))
		{
			//Update the alert...
			comm.classList.remove("user-info");
			comm.classList.add("user-alert");
		}
	}
	commList = null;

	//Comm'admin visibility
	if (winLocStr.includes("?mut"))
	{
		var commSwapper = document.getElementById("comm-swapper");
		if (commSwapper !== null)
		{
			commSwapper.state = winLocStr.substring(winLocStr.length - 1);
			if (commSwapper.state == 1)
			{
				commSwapper.checked = true;
			} 
			else if (commSwapper.state == 2)
			{
				commSwapper.indeterminate = true;
			}
		}
	}

	//Verify RGPD validation (once)...
	if (typeof localStorage != 'undefined')
	{
		if (sessionStorage.getItem("jfr_rgpd") === null)
		{
			if (typeof localStorage != 'undefined')
			{
				var rgpd_ls = localStorage.getItem("jfr_rgpd");
				if (rgpd_ls !== null
					&& (rgpd_ls + (1000*60*60*24*7)) > Date.now())		// 7 days
				{
					sessionStorage.setItem("jfr_rgpd", Date.now().toString());
					valid_rgpd();
				}
			}
		}
		else { valid_rgpd(); }
	}
	else { valid_rgpd(); }

	// Get the reading position...
	if (winLocStr.includes(".read-"))
	{
		var locReading = null;
		if (typeof localStorage != 'undefined')
		{
			// Get state in local storage...
			locReading = localStorage.getItem("jfr_rdng");
		}
		else
		{
			// Get state in cookie...
			locReading = getCookValue("jfr_rdng");
		}
		if (locReading !== null)
		{
			//Report the save...
			var savedPart = document.getElementById("reading--" + locReading);
			if (savedPart !== null)
			{
				savedPart.classList.remove("user-info");
				savedPart.classList.add("user-warning");
				if (!(winLocStr.includes("#comments")))
				{
					savedPart.scrollIntoView();
				}
			}
		}
	}
	winLocStr = null;
}

// -----------------------------

function getCookValue(cookName)
{
	for (let iCook of document.cookie.split(";"))
	{
		if (iCook.includes(cookName + "="))
		{
			return (iCook.replace(cookName + "=", "")).trim();
		}
	}
	return null;
}

function getReadingChapter()
{
	var rLink = document.getElementById("reading");
	if (rLink !== null)
	{
		var lastChapter = null;
		if (typeof localStorage != 'undefined')
		{
			// Get the last chapter...
			lastChapter = localStorage.getItem("jfr_rchp");
			if (lastChapter !== null)
			{
				window.location = lastChapter;
			}
		}
		if (lastChapter === null)
		{
			rLink.id = "no-reading";
			rLink.title = "Aucun historique de lecture...";
		}
	}
}

// -----------------------------

function valid_rgpd()
{
	var rgpd = document.getElementById("rgpd");
	if (rgpd !== null)
	{
		rgpd.style.display = "none";
		var cookies = document.getElementById("cookies");
		if (cookies !== null)
		{
			cookies.style.display = "none";
		}
	}
	// Store validation in local storage...
	if (typeof localStorage != 'undefined')
	{
		localStorage.setItem('jfr_rgpd', Date.now().toString());
	}
}

function explain_rgpd()
{
	var cookies = document.getElementById("cookies");
	if (cookies !== null)
	{
		cookies.style.display = "block";
	}
}