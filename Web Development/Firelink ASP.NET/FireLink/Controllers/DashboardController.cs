using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace FireLink.Controllers
{
    public class DashboardController : Controller
    {
        // GET: Dashboard
        [Route("Dashboard")]
        [Authorize]
        public ActionResult Index()
        {
            return View("~/Views/Dashboard/FileSearch.cshtml");
        }
    }
}