SELECT
	d.name, d.code as Department ,
	c.code as Code, c.title as Title, c.units, 
	s.code as section, s.sect, s.reg as num_registered, s.seats as total_seats, s.instructor_ids, s.loc as Location,
	u.email, u.phone,
	a.active
FROM users u, alerts a, sections s, courses c, departments d
WHERE a.user_id = u.user_id
	AND s.id = a.section_id
	AND c.id = s.course_id
	AND d.id = c.department_id
	;
