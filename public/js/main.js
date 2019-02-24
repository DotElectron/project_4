// --------------------------
// --------------------------
// Body Adjustement (multi-jobs)
function body_adjustement()
{
	// Main replacement (margin-top)...
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
}