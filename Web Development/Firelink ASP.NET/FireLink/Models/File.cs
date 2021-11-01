using FireLink.Services;
using System;
using System.Linq;
using Microsoft.AspNet.Identity.EntityFramework;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Web;

namespace FireLink.Models
{
    public class File
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.None)]
        public string Id { set; get; }

        public string Name { set; get; }
        public float Size { set; get; }
        public string Extension { set; get; }
        public byte Keepfor { set; get; }
        public string SecureCode { set; get; }
        public string Username { set; get; }
        public DateTime CreatedAt { get; set; }

        public File()
        {
        }

        public File(HttpPostedFileWrapper file, HttpRequestWrapper request)
        {
            this.CreatedAt = DateTime.Now;
            this.SecureCode = Security.GenerateSecureCode();
            this.Id = Security.EncryptFileId(this.CreatedAt.ToString(), this.SecureCode);
            this.Name = Security.EncryptFileName(this.Id, file.FileName.Substring(0, file.FileName.LastIndexOf(".")), this.SecureCode);
            this.Size = (float)Math.Round(file.ContentLength / 1000000f, 2);
            this.Extension = file.FileName.Substring(file.FileName.LastIndexOf(".") + 1);
            this.Keepfor = Convert.ToByte(request.Form["keepfor"]);
            this.Username = request.Form["username"];
        }

        public string ResetFileName()
        {
            string originalFilename = new Vigenere().full_key_decrypt(this.Name, this.SecureCode);
            this.Name = originalFilename.Substring(13);
            return this.Name;
        }
    }
}