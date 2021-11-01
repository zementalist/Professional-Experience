using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace FireLink.Controllers
{
    public class HomeController : Controller
    {
        public ActionResult Index()
        {
            ViewBag.Title = "Home Page";

            return View();
        }

        [HttpGet]
        [Route("faq")]
        public ActionResult ShowFaq()
        {
            return View("~/Views/FAQ.cshtml");
        }
    }
}
