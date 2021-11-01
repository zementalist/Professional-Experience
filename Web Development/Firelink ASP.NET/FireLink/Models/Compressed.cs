using System;
using System.Web;

namespace FireLink.Models
{
    public class Compressed : File
    {
        public int? NumberOfItems { get; set; }

        public Compressed()
        {
        }

        public Compressed(HttpPostedFileWrapper file, HttpRequestWrapper request) : base(file, request)
        {
            this.NumberOfItems = new Random().Next(1, 15); // Temporarely arbitery
        }
    }
}