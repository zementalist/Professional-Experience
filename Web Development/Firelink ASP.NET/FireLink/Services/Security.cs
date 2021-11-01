using System;
using System.Text.RegularExpressions;

namespace FireLink.Services
{
    public class Security
    {
        public static string GenerateSecureCode()
        {
            string password = System.Web.Security.Membership.GeneratePassword(8, 0);
            return Regex.Replace(password, @"[^a-zA-Z0-9]", "G");
        }

        public static string EncryptFileId(string createdAt, string secureCode)
        {
            return new Vigenere().full_key(Regex.Replace(createdAt, "[^a-zA-Z0-9]", ""), secureCode);
        }

        public static string EncryptFileName(string id, string filename, string secureCode)
        {
            filename = Regex.Replace(filename, @"[^a-zA-Z0-9]", "");
            if (String.IsNullOrEmpty(filename))
                filename = GenerateSecureCode();
            return new Vigenere().full_key(id + filename, secureCode);
        }
    }
}