/**
 * @author Andrea
 */
AjaxRequester =
{
	getRequester: function()
	{
		var requester = null;

			// prova ad istanziare l'oggetto requester
		try
		{
			requester = new XMLHttpRequest();
		}
		catch(error)
		{
			try
			{
				requester = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(error)
			{
				requester = null;
			}
		}
		return requester;

	} // end getRequester: function(to, m...
};