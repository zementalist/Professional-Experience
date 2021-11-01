using FireLink.Models;
using System;

namespace FireLink.Services
{
    public class FileManager
    {
        private ApplicationDbContext _context;

        public FileManager()
        {
            _context = new ApplicationDbContext();
        }

        public FileTypeDetails FileQuery(string fileType)
        {
            string[] arrayOfMimes;
            string maxSize, storePath, iconFA;
            if (fileType == "image")
            {
                arrayOfMimes = new string[] { "jpeg", "jpg", "png", "gif", "bmp", "ico", "pjpeg", "svg" };
                maxSize = "4999";
                storePath = "/public/files/Image/";
                iconFA = "far fa-image";
            }
            else if (fileType == "video")
            {
                arrayOfMimes = new string[] { "mp4", "mpg", "flv", "avi", "3gp", "rm", "wmv", "m4v" };
                maxSize = "14999";
                storePath = "/public/files/Video/";
                iconFA = "far fa-file-video";
            }
            else if (fileType == "audio")
            {
                arrayOfMimes = new string[] { "mp3", "mpga", "wav", "wma", "mpa", "cda", "acc", "m4a", "mid", "amr", "ogg" };
                maxSize = "14999";
                storePath = "/public/files/Audio/";
                iconFA = "far fa-file-audio";
            }
            else if (fileType == "compressed")
            {
                arrayOfMimes = new string[] { "rar", "zip", "7z", "z", "rpm", "tar.gz" };
                maxSize = "999";
                storePath = "/public/files/Compressed/";
                iconFA = "fas fa-file-archive";
            }
            else if (fileType == "document")
            {
                arrayOfMimes = new string[] { "pdf", "doc", "docx", "ppt", "pptx", "xlr", "xls", "xlsx", "rtf", "wks", "wps", "txt" };
                maxSize = "14999";
                storePath = "/public/files/Document/";
                iconFA = "far fa-file-alt";
            }
            else if (fileType == "other")
            {
                arrayOfMimes = null;
                maxSize = null;
                storePath = null;
                iconFA = "far fa-file";
            }
            else
            {
                arrayOfMimes = null;
                maxSize = null;
                storePath = null;
                iconFA = null;
            }
            FileTypeDetails details = new FileTypeDetails(arrayOfMimes, maxSize, storePath, iconFA, fileType);
            return details;
        }

        public Type GetModelType(string filetype)
        {
            switch (filetype)
            {
                case "image":
                    return typeof(Image);

                case "video":
                    return typeof(Video);

                case "audio":
                    return typeof(Audio);

                case "document":
                    return typeof(Document);

                case "compressed":
                    return typeof(Compressed);
            }
            return null;
        }

        public Type GetContextType(string filetype)
        {
            switch (filetype)
            {
                case "image":
                    return _context.Image.GetType();

                case "video":
                    return _context.Video.GetType();

                case "audio":
                    return _context.Audio.GetType();

                case "document":
                    return _context.Document.GetType();

                case "compressed":
                    return _context.Compressed.GetType();
            }
            return null;
        }
    }
}