using System;
using System.Web;

namespace FireLink.Models
{
    public class Audio : File
    {
        public int? Length { get; set; }

        public Audio()
        {
        }

        public Audio(HttpPostedFileWrapper file, HttpRequestWrapper request) : base(file, request)
        {
            this.Length = new Random().Next(1, 8); // Temporarely arbitery
        }
    }
}