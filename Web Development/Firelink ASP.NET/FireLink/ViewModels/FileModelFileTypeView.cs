using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

using FireLink.Services;

namespace FireLink.ViewModels
{
    public class FileModelFileTypeView
    {
        public dynamic File;
        public FileTypeDetails FileTypeDetails;
        public bool OwnerView;

        public FileModelFileTypeView(dynamic file, FileTypeDetails details, bool ownerView)
        {
            File = file;
            FileTypeDetails = details;
            OwnerView = ownerView;
        }
    }
}