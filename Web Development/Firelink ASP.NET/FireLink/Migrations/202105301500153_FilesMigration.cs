namespace FireLink.Migrations
{
    using System.Data.Entity.Migrations;

    public partial class FilesMigration : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.Audios",
                c => new
                {
                    Id = c.String(nullable: false, maxLength: 128),
                    Length = c.Int(),
                    Name = c.String(),
                    Size = c.Single(nullable: false),
                    Extension = c.String(),
                    Keepfor = c.Byte(nullable: false),
                    SecureCode = c.String(),
                    Username = c.String(),
                    CreatedAt = c.DateTime(nullable: false),
                })
                .PrimaryKey(t => t.Id);

            CreateTable(
                "dbo.Compresseds",
                c => new
                {
                    Id = c.String(nullable: false, maxLength: 128),
                    NumberOfItems = c.Int(),
                    Name = c.String(),
                    Size = c.Single(nullable: false),
                    Extension = c.String(),
                    Keepfor = c.Byte(nullable: false),
                    SecureCode = c.String(),
                    Username = c.String(),
                    CreatedAt = c.DateTime(nullable: false),
                })
                .PrimaryKey(t => t.Id);

            CreateTable(
                "dbo.Documents",
                c => new
                {
                    Id = c.String(nullable: false, maxLength: 128),
                    NumberOfPages = c.Int(),
                    Name = c.String(),
                    Size = c.Single(nullable: false),
                    Extension = c.String(),
                    Keepfor = c.Byte(nullable: false),
                    SecureCode = c.String(),
                    Username = c.String(),
                    CreatedAt = c.DateTime(nullable: false),
                })
                .PrimaryKey(t => t.Id);

            CreateTable(
                "dbo.Images",
                c => new
                {
                    Id = c.String(nullable: false, maxLength: 128),
                    Width = c.Int(),
                    Height = c.Int(),
                    Name = c.String(),
                    Size = c.Single(nullable: false),
                    Extension = c.String(),
                    Keepfor = c.Byte(nullable: false),
                    SecureCode = c.String(),
                    Username = c.String(),
                    CreatedAt = c.DateTime(nullable: false),
                })
                .PrimaryKey(t => t.Id);

            CreateTable(
                "dbo.Reports",
                c => new
                {
                    Id = c.Int(nullable: false, identity: true),
                    Email = c.String(),
                    Subject = c.String(),
                    Body = c.String(),
                    Type = c.String(),
                    Seen = c.Boolean(nullable: false),
                    CreatedAt = c.DateTime(nullable: false),
                })
                .PrimaryKey(t => t.Id);

            CreateTable(
                "dbo.AspNetRoles",
                c => new
                {
                    Id = c.String(nullable: false, maxLength: 128),
                    Name = c.String(nullable: false, maxLength: 256),
                })
                .PrimaryKey(t => t.Id)
                .Index(t => t.Name, unique: true, name: "RoleNameIndex");

            CreateTable(
                "dbo.AspNetUserRoles",
                c => new
                {
                    UserId = c.String(nullable: false, maxLength: 128),
                    RoleId = c.String(nullable: false, maxLength: 128),
                })
                .PrimaryKey(t => new { t.UserId, t.RoleId })
                .ForeignKey("dbo.AspNetRoles", t => t.RoleId, cascadeDelete: true)
                .ForeignKey("dbo.AspNetUsers", t => t.UserId, cascadeDelete: true)
                .Index(t => t.UserId)
                .Index(t => t.RoleId);

            CreateTable(
                "dbo.AspNetUsers",
                c => new
                {
                    Id = c.String(nullable: false, maxLength: 128),
                    Email = c.String(maxLength: 256),
                    EmailConfirmed = c.Boolean(nullable: false),
                    PasswordHash = c.String(),
                    SecurityStamp = c.String(),
                    PhoneNumber = c.String(),
                    PhoneNumberConfirmed = c.Boolean(nullable: false),
                    TwoFactorEnabled = c.Boolean(nullable: false),
                    LockoutEndDateUtc = c.DateTime(),
                    LockoutEnabled = c.Boolean(nullable: false),
                    AccessFailedCount = c.Int(nullable: false),
                    UserName = c.String(nullable: false, maxLength: 256),
                })
                .PrimaryKey(t => t.Id)
                .Index(t => t.UserName, unique: true, name: "UserNameIndex");

            CreateTable(
                "dbo.AspNetUserClaims",
                c => new
                {
                    Id = c.Int(nullable: false, identity: true),
                    UserId = c.String(nullable: false, maxLength: 128),
                    ClaimType = c.String(),
                    ClaimValue = c.String(),
                })
                .PrimaryKey(t => t.Id)
                .ForeignKey("dbo.AspNetUsers", t => t.UserId, cascadeDelete: true)
                .Index(t => t.UserId);

            CreateTable(
                "dbo.AspNetUserLogins",
                c => new
                {
                    LoginProvider = c.String(nullable: false, maxLength: 128),
                    ProviderKey = c.String(nullable: false, maxLength: 128),
                    UserId = c.String(nullable: false, maxLength: 128),
                })
                .PrimaryKey(t => new { t.LoginProvider, t.ProviderKey, t.UserId })
                .ForeignKey("dbo.AspNetUsers", t => t.UserId, cascadeDelete: true)
                .Index(t => t.UserId);

            CreateTable(
                "dbo.Videos",
                c => new
                {
                    Id = c.String(nullable: false, maxLength: 128),
                    Duration = c.Int(),
                    Name = c.String(),
                    Size = c.Single(nullable: false),
                    Extension = c.String(),
                    Keepfor = c.Byte(nullable: false),
                    SecureCode = c.String(),
                    Username = c.String(),
                    CreatedAt = c.DateTime(nullable: false),
                })
                .PrimaryKey(t => t.Id);
        }

        public override void Down()
        {
            DropForeignKey("dbo.AspNetUserRoles", "UserId", "dbo.AspNetUsers");
            DropForeignKey("dbo.AspNetUserLogins", "UserId", "dbo.AspNetUsers");
            DropForeignKey("dbo.AspNetUserClaims", "UserId", "dbo.AspNetUsers");
            DropForeignKey("dbo.AspNetUserRoles", "RoleId", "dbo.AspNetRoles");
            DropIndex("dbo.AspNetUserLogins", new[] { "UserId" });
            DropIndex("dbo.AspNetUserClaims", new[] { "UserId" });
            DropIndex("dbo.AspNetUsers", "UserNameIndex");
            DropIndex("dbo.AspNetUserRoles", new[] { "RoleId" });
            DropIndex("dbo.AspNetUserRoles", new[] { "UserId" });
            DropIndex("dbo.AspNetRoles", "RoleNameIndex");
            DropTable("dbo.Videos");
            DropTable("dbo.AspNetUserLogins");
            DropTable("dbo.AspNetUserClaims");
            DropTable("dbo.AspNetUsers");
            DropTable("dbo.AspNetUserRoles");
            DropTable("dbo.AspNetRoles");
            DropTable("dbo.Reports");
            DropTable("dbo.Images");
            DropTable("dbo.Documents");
            DropTable("dbo.Compresseds");
            DropTable("dbo.Audios");
        }
    }
}