using System;
using System.Web;

namespace FireLink.Models
{
    public class Video : File
    {
        public int? Duration { get; set; }

        public Video()
        {
        }

        public Video(HttpPostedFileWrapper file, HttpRequestWrapper request) : base(file, request)
        {
            this.Duration = new Random().Next(1, 8); // Temporarely arbitery
        }
    }
}