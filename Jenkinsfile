@Library('jenkins-common')_

node("all-biulds"){
    stage('Load credentials') {
        withCredentials([
            string(credentialsId: 'goit_jenkins_build_bot_api_key', variable: 'telegramNotifyChannelBotApiToken'),
            string(credentialsId: 'goit_jenkins_build_chat_id', variable: 'telegramNotifyChannelChatId'),

            string(credentialsId: 'tech_alert_bot_api_key', variable: 'telegramAlertChannelBotApiToken'),
            string(credentialsId: 'tech_alert_chat_id', variable: 'telegramAlertChannelChatId'),

            //add ftp credential
            string(credentialsId: 'ftp_user_pass_host_fot_goiteens_com_develop', variable: 'ftpUserPassAndHost')
        ]) {
                env.telegramNotifyChannelBotApiToken = telegramNotifyChannelBotApiToken;
                env.telegramNotifyChannelChatId = telegramNotifyChannelChatId;
                env.telegramAlertChannelBotApiToken = telegramAlertChannelBotApiToken;
                env.telegramAlertChannelChatId = telegramAlertChannelChatId;

                env.ftpUserPassAndHost = ftpUserPassAndHost;

                env.gitRepository = 'git@github.com:SoftRyzen/wp-goiteens.com.git';
                env.gitBranch = 'develop';
        }
    }

    stage('Setup texts') {
        def buildUrl = env.RUN_DISPLAY_URL;

        env.startBuildText = java.net.URLEncoder.encode("Build *${JOB_NAME}* started\n[Go to build](${buildUrl})", "UTF-8");
        env.successBuildText = java.net.URLEncoder.encode("Build *${JOB_NAME}* finished SUCCESS.\nTime: TIME\n[Go to build](${buildUrl})", "UTF-8");
        env.failedBuildText = java.net.URLEncoder.encode("Build *${JOB_NAME}* FAILED.\nTime: TIME\n[Go to build](${buildUrl})", "UTF-8");
    }

    stage('Pre Build Notify') {
        //Send message to channel
        sendTelegramChannelMessage(
            env.telegramNotifyChannelBotApiToken,
            env.telegramNotifyChannelChatId,
            env.startBuildText
        );

    }

    stage('Clone Git Repo') {
        catchError(buildResult: 'FAILURE', stageResult: 'FAILURE') {
            git branch: env.gitBranch, credentialsId: 'pasha-goitacad-ssh', url: env.gitRepository
        }
    }

    stage('Build'){
        def success = 'SUCCESS'.equals(currentBuild.currentResult);
        sh "./build.sh"
    }

    stage('Deploy') {
         def success = 'SUCCESS'.equals(currentBuild.currentResult);

        if (success) {
            catchError(buildResult: 'FAILURE', stageResult: 'FAILURE') {

                sh "ncftpput -z ${env.ftpUserPassAndHost} ./ ./*"

                //sh "ncftpput ${env.ftpUserAndPass} ./"
                //sh "rm -r *"
            }
        }
    }

    stage('Post Build Notify') {
        def success = 'SUCCESS'.equals(currentBuild.currentResult);
        def previousBuildSuccess = true;
        if (currentBuild.previousBuild != null && !'SUCCESS'.equals(currentBuild.previousBuild.currentResult)) {
            previousBuildSuccess = false;
        }

        def message = '';
        if (success) {
            message = env.successBuildText;
        } else {
            message = env.failedBuildText;
        }

        //Calculate time
        def durationSeconds = (int) (currentBuild.duration / 1000);
        def durationMinutes = (int) (durationSeconds / 60);
        durationSeconds -= durationMinutes * 60;

        message = message.replace('TIME', "${durationMinutes} min ${durationSeconds} sec");

        //Send message to global notify channel
        sendTelegramChannelMessage(
            env.telegramNotifyChannelBotApiToken,
            env.telegramNotifyChannelChatId,
            message
        )

        //Send message to alert channel only if failed or restore build success
        if (!success || (success && !previousBuildSuccess)) {
             sendTelegramChannelMessage(
                env.telegramAlertChannelBotApiToken,
                env.telegramAlertChannelChatId,
                message
            )
        }
    }
}
