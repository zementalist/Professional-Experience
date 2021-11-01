namespace FireLink.Services
{
    public class FileTypeDetails
    {
        public string[] AllowedExtensions { get; set; }
        public string MaxSize { get; set; }
        public string StorePath { get; set; }
        public string Icon { get; set; }
        public string Type { get; set; }

        public FileTypeDetails(string[] allowed, string maxsize, string storepath, string icon, string type)
        {
            this.AllowedExtensions = allowed;
            this.MaxSize = maxsize;
            this.StorePath = storepath;
            this.Icon = icon;
            this.Type = type;
        }
    }
}