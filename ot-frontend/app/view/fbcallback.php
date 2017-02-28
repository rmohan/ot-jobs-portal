<html>
    <head>
        <script>
            var accessToken = '<?= $accessToken ?>';
            opener.socialLogin.setFacebookAccessToken(accessToken);   
            self.close();
        </script>
    </head>
</html>
