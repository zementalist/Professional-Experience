using System;
using System.Web;

namespace FireLink.Models
{
    public class Document : File
    {
        public int? NumberOfPages { get; set; }

        public Document()
        {
        }

        public Document(HttpPostedFileWrapper file, HttpRequestWrapper request) : base(file, request)
        {
            this.NumberOfPages = new Random().Next(1, 30); // Temporarely arbitery
        }
    }
}