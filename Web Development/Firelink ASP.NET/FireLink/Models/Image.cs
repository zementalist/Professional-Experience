using System;
using System.Web;
using System.Linq;

namespace FireLink.Models
{
    public class Image : File
    {
        public int? Width { get; set; }
        public int? Height { get; set; }

        public Image()
        {
        }

        public Image(HttpPostedFileWrapper file, HttpRequestWrapper request) : base(file, request)
        {
            this.Width = new Random().Next(200, 1500); // Temporarely arbitery
            this.Height = new Random().Next(200, 1500); // Temporarely arbitery
        }
    }
}