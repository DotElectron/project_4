// --------------------------
// --------------------------
// Navbar switch to connect...
function switch_connection()
{
	var blockConnect = document.getElementById("connect");
	if (blockConnect !== null)
	{
		if (blockConnect.style.display === ""
			|| blockConnect.style.display === "none")
		{
			blockConnect.style.display = "block";
			hasRegistration();
		}
		else
		{
			blockConnect.style.display = "none";
		}
		blockConnect = null;
	}
}
function hasConnection()
{
	var blockConnect = document.getElementById("connect");
	if (blockConnect !== null)
	{
		if (blockConnect.style.display = "block")
		{
			blockConnect.style.display = "none";
		}
		blockConnect = null;
	}
}

// Navbar switch to register...
function switch_registration()
{
	var blockRegister = document.getElementById("register");
	if (blockRegister !== null)
	{
		if (blockRegister.style.display === ""
			|| blockRegister.style.display === "none")
		{
			blockRegister.style.display = "block";
			hasConnection();
		}
		else
		{
			blockRegister.style.display = "none";
		}
		blockRegister = null;
	}
}
function hasRegistration()
{
	var blockRegister = document.getElementById("register");
	if (blockRegister !== null)
	{
		if (blockRegister.style.display = "block")
		{
			blockRegister.style.display = "none";
		}
		blockRegister = null;
	}
}

// Navbar switch to selected chapter...
function switch_chapter()
{
	var blockChapter = document.getElementById("readChapter");
	if (blockChapter !== null)
	{
		location.href = blockChapter.value;
	}
}