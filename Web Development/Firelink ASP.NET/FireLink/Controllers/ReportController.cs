using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

using FireLink.Models;

namespace FireLink.Controllers
{
    public class ReportController : Controller
    {
        private Models.ApplicationDbContext _context;

        public ReportController()
        {
            _context = new Models.ApplicationDbContext();
        }

        protected override void Dispose(bool disposing)
        {
            _context.Dispose();
        }

        // GET: Report
        public ActionResult Index()
        {

                var reports = _context.Report.ToList();
                return View("~/Views/FileView/FileReport.cshtml", reports);

            
        }

        [HttpGet]
        [Route("report/{filetype}/{id}")]
        public ActionResult ShowReportForm(string filetype, string id)
        {
            ViewData["filetype"] = filetype;
            ViewData["id"] = id;
            return View("~/Views/FileView/FileReport.cshtml");
        }


        [HttpGet]
        [Route("contactus")]
        public ActionResult ShowReportForm()
        {

            return View("~/Views/FileView/FileReport.cshtml");
        }

        [HttpPost]
        [Route("report")]
        public ActionResult Store()
        {
            Report report = new Report(Request);

            _context.Report.Add(report);
            _context.SaveChanges();

            ViewData["success"] = "Your report is submitted successfully";
            return View("~/Views/Home/Index.cshtml");
        }
    }
}