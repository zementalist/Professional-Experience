using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace FireLink.Models
{
    public class Report
    {
        public int Id { set; get; }
        public string Email { set; get; }
        public string Subject { set; get; }
        public string Body { set; get; }
        public string Type { set; get; }
        public bool Seen { set; get; } = false;
        public DateTime CreatedAt { set; get; }

        public Report() { }
        public Report(HttpRequestBase Request)
        {
            this.Email = Request.Form["email"];
            this.Subject = Request.Form["subject"];
            this.Body = Request.Form["body"];
            this.Type = "file";
            this.Seen = false;
            this.CreatedAt = DateTime.Now;
        }
    }
}