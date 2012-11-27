import smtplib
import sys

args = (sys.argv)

SMTPServer = args[1]
SMTPUser = args[2] 
SMTPPassword = args[3]
Rec = args[4]
Sender = args[5]
Message = open(args[6]).read()
print SMTPServer
serv = smtplib.SMTP_SSL(SMTPServer, 465)
serv.ehlo()
if (serv.has_extn("STARTTLS")):
		serv.starttls()
serv.login(SMTPUser, SMTPPassword)
header = 'To:' + Rec + '\n' + 'From: ' + Sender + '\n' + 'From: ' + Sender + '\n'
message = header + Message;
serv.sendmail(Sender, Rec, message)
serv.close()
