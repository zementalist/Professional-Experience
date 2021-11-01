using FireLink.Services;
using FireLink.ViewModels;
using System;
using System.Data.Entity;
using System.Linq;
using System.Net.Http;
using System.Web.Mvc;
using FireLink.Models;
using System.Collections.Generic;

namespace FireLink.Controllers
{
    public class FileController : Controller
    {
        private Models.ApplicationDbContext _context;
        private FileManager manager;


        public FileController()
        {
            _context = new Models.ApplicationDbContext();
            manager = new FileManager();
        }

        protected override void Dispose(bool disposing)
        {
            _context.Dispose();
        }

        // function to get mimes,maxsize,file-path-to-store,icon class font-awesome, tableName by(type)

        // GET: FileUpload
        [HttpGet]
        [Route("UploadForm/{filetype}")]
        public ActionResult Index(string filetype)
        {
            FileTypeDetails FileDetails = manager.FileQuery(RouteData.Values["filetype"].ToString());
            return View("~/Views/FileUpload/UploadView.cshtml", FileDetails);
        }

        [HttpPost]
        [Route("upload")]
        public ActionResult Upload()
        {
            // Initialize Context & Path to files
            var ctx = this.HttpContext;
            var root = ctx.Server.MapPath("~/");
            

            // Receive file & meta data
            var provider = new MultipartFormDataStreamProvider(root);
            var files = Request.Files;
            var input_file = files[0];
            string filetype = Request.Form["type"];
            var filesPath = $"{root}/Resources/userfiles/{filetype}/";

            // Initialize File
            var FileModelType = manager.GetModelType(filetype);
            var FileModelObject = Activator.CreateInstance(FileModelType, input_file, Request);
            dynamic File = Convert.ChangeType(FileModelObject, FileModelType);

            // Initialize DB Context
            var FileContext = _context.GetContext(filetype);

            // Save File to disk & DB
            input_file.SaveAs($"{filesPath + File.Name + "." + File.Extension}");
            FileContext.Add(File);

            // Save DB Changes
            _context.SaveChanges();

            FileTypeDetails fileDetails = manager.FileQuery(filetype);

            FileModelFileTypeView data = new FileModelFileTypeView(File, fileDetails, true);


            return View("~/Views/FileView/FileShow.cshtml", data);
        }

        [Route("allfiles")]
        public ActionResult GetAll()
        {
            var files = _context.Image.ToList();
            var json = new JsonResult();
            json.JsonRequestBehavior = JsonRequestBehavior.AllowGet;
            json.Data = files;
            return json;
        }

        [HttpGet]
        [Route("files/{filetype}/{id}")]
        public ActionResult GetFile(string filetype, string id)
        {
            var FileContext = _context.GetContext(filetype);
            dynamic file = FileContext.Find(id);
            var json = new JsonResult();
            json.JsonRequestBehavior = JsonRequestBehavior.AllowGet;
            if (file != null)
            {
                json.Data = file;
            }
            FileTypeDetails fileDetails = manager.FileQuery(filetype);

            FileModelFileTypeView data = new FileModelFileTypeView(file, fileDetails, false);

            return View("~/Views/FileView/FileShow.cshtml", data);
        }

        

        public List<File> FindFileByName(List<File> files, string name)
        {
            List<File> results = new List<File>();
            foreach(File file in files)
            {
                if (file.ResetFileName() == name)
                    results.Add(file);
            }
            return results;
        }
        
        [HttpPost]
        [Route("control/find/file")]
        [Authorize]
        public ActionResult GetFile()
        {
            Type ModelType = manager.GetModelType(Request.Form["type"]);
            var FileContext = (IQueryable<File>)_context.Set(ModelType);
            string method = Request.Form["method"];
            string keyword = Request.Form["search"];
            string sort = Request.Form["sort"];

            var json = new JsonResult();
            switch(method)
            {
                case "Id":
                    var fileById = FileContext.Where(file => file.Id == keyword).ToListAsync().Result;
                    dynamic results = sort == "ASC" ? fileById.OrderBy(file => file.CreatedAt) : fileById.OrderByDescending(file => file.CreatedAt);
                    json.Data = results;
                    break;
                case "Name":
                    List<File> filesByName = FileContext.ToList();
                    List<File> foundFiles = FindFileByName(filesByName, keyword);
                    results = sort == "ASC" ? foundFiles.OrderBy(file => file.CreatedAt) : foundFiles.OrderByDescending(file => file.CreatedAt);
                    json.Data = results;
                    break;
                case "Username":
                    var filesByUsername = FileContext.Where(file => file.Username == keyword).ToListAsync().Result;
                    results = sort == "ASC" ? filesByUsername.OrderBy(file => file.CreatedAt) : filesByUsername.OrderByDescending(file => file.CreatedAt);
                    json.Data = results;
                    break;
            }
            
            
            return json;
            
        }

        [HttpPost]
        [Route("files/{filetype}/{id}/delete")]
        public ActionResult Delete(string filetype, string id)
        {
            string InputSecureCode = Request.Form["securecode"];
            string responseType = Request.Form["responsetype"];
            var FileContext = _context.GetContext(filetype);
            dynamic file = FileContext.Find(id);
            var json = new JsonResult();
            if (file != null)
            {
                if(file.SecureCode == InputSecureCode)
                {
                    string root = this.HttpContext.Server.MapPath("~/");
                    string filePath = $"{root}/Resources/userfiles/{filetype}/{file.Name + "." + file.Extension}";
                    FileContext.Remove(file);
                    System.IO.File.Delete(filePath);
                    _context.SaveChanges();
                    json.Data = 1;
                    ViewData["success"] = $"File is deleted successfully.";

                }
                else
                {
                    ViewData["danger"] = "You are NOT allowed to delete this file";
                }
            }
            else
            {
                ViewData["info"] = "File does not exist!";
                json.Data = 0;
            }

            if (responseType == "json")
                return json;
            else
                return View("~/Views/Home/Index.cshtml");

        }

    }
}