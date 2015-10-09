#BasicBlogBundle

This bundle is indented for projects who need some basic blog features. Please see below a list of features already included:

Front side
- view all blog posts with pagination
- view individual blog posts and their comments
- add comments

Admin
- create new post. includes tags and uploading photo
- manage all blog posts with Edit and Delete options.
- manage comments with options to Approve/Unapprove or Delete.

#Installation

Install using Composer:

	composer require cpana/basicblogbundle:dev-master

Register the bundle in AppKernel.php by adding:

	new CPANA\BasicBlogBundle\CPANABasicBlogBundle(),

Import paths in app/config/routing.yml by adding:

    CPANABasicBlogBundle:
    resource: "@CPANABasicBlogBundle/Resources/config/routing.yml"

Make sure to have configured your database in app/config/parameters.yml
Generate you schema using console:

	php app/console cache:clear
	php app/console doctrine:schema:update --force

#Usage

Go to browser and navigate to "your website/app_dev.php/admin/blog"
Add a blog post and then go to "your website/app_dev.php/blog" to see the results.
