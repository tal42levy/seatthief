import sqlite3
import os
import smtplib

dbUrl = "public_html/pyclasser/example.sqlite3"
mainUrl = "seatthief.com"

def email(SMTPServer, SMTPUser, SMTPPassword, Rec, Sender, Message):
	serv = smtplib.SMTP_SSL(SMTPServer, 465)
	serv.ehlo()
	serv.login(SMTPUser, SMTPPassword)
	header = 'To:' + Rec + '\n' + 'From: ' + Sender + ' \n'
	message = header + Message;
	serv.sendmail(Sender, Rec, message)
	serv.close()

def sendAlert(alert, user, course, department):
	#Called after finding that there is an empty seat in the section specified by @param alert
	#Sends email, text to specific user
	message = "Hello %s,\n\n The class you set an alert for, %s, has had a seat in it open up.\n If you'd like to set another alert, or were unable to get this spot, just head to %s to set it up! \n\n Good luck!"  % ( user[2], department[0] + '-' + course[1], mainUrl )
	receiver = user[0]
	email('mail.seatthief.com', 'info@seatthief.com', 'jayBHC42', receiver, 'info@seatthief.com', message)
	sql = 'update alerts set active = 0 where alert_id = %s' % (alert[3])
	c.execute(sql)
	conn.commit()
	print sql

conn = sqlite3.connect(dbUrl)
c = conn.cursor()
quer = "SELECT user_id, active, section_id, alert_id FROM alerts WHERE active = 1"
for row in c.execute(quer).fetchall():
	section_ID = (row[2], )
	c.execute('select reg, seats, course_id from sections where id =?', section_ID)
	results = c.fetchone()
	if results is None:
		print str(row[2]) + " didn't appear in the database"
		next
	else:
		reg = results[0]
		seats = results[1]
		if (reg < seats):
			user = c.execute('select email, phone, username from users where user_id = %d' % (row[0])).fetchone()
			course = c.execute('select department_id, code from courses where id = %d' % (results[2])).fetchone()
			department = c.execute('select code from departments where id = %d' % (course[0])).fetchone()
			print user
			sendAlert(row, user, course, department)

