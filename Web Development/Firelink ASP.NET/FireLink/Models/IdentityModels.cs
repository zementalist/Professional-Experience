using Microsoft.AspNet.Identity;
using Microsoft.AspNet.Identity.EntityFramework;
using System.Data.Entity;
using System.Security.Claims;
using System.Threading.Tasks;
using System.Linq;

namespace FireLink.Models
{
    // You can add profile data for the user by adding more properties to your ApplicationUser class, please visit https://go.microsoft.com/fwlink/?LinkID=317594 to learn more.
    public class ApplicationUser : IdentityUser
    {
        public async Task<ClaimsIdentity> GenerateUserIdentityAsync(UserManager<ApplicationUser> manager)
        {
            // Note the authenticationType must match the one defined in CookieAuthenticationOptions.AuthenticationType
            var userIdentity = await manager.CreateIdentityAsync(this, DefaultAuthenticationTypes.ApplicationCookie);
            // Add custom user claims here
            return userIdentity;
        }
    }



    public class ApplicationDbContext : IdentityDbContext<ApplicationUser>
    {
        public DbSet<Image> Image { set; get; }
        public DbSet<Document> Document { set; get; }
        public DbSet<Audio> Audio { set; get; }
        public DbSet<Video> Video { set; get; }
        public DbSet<Compressed> Compressed { set; get; }
        public DbSet<Report> Report { set; get; }

        public ApplicationDbContext()
            : base("DefaultConnection", throwIfV1Schema: false)
        {
        }

        public static ApplicationDbContext Create()
        {
            return new ApplicationDbContext();
        }

        public DbSet GetContext(string filetype)
        {
            switch (filetype)
            {
                case "image":
                    return Image;

                case "video":
                    return Video;

                case "audio":
                    return Audio;

                case "document":
                    return Document;

                case "compressed":
                    return Compressed;
            }
            return null;
        }
    }
}