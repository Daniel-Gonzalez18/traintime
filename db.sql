CREATE TABLE 'users'(
    'id' INTEGER PRIMARY KEY AUTOINCREMENT,
    'username' TEXT NOT NULL,
    'password' TEXT NOT NULL,
    'email' TEXT NOT NULL,
)
CREATE TABLE 'groups'(
    'id' INTEGER PRIMARY KEY AUTOINCREMENT,
    'name' TEXT NOT NULL,
    'description' TEXT NOT NULL,
    'creator' INTEGER NOT NULL,
    CONSTRAINT 'creator_fk' FOREIGN KEY('creator') REFERENCES 'users'('id')
)
CREATE TABLE 'groups_users'(
    'group_id' INTEGER NOT NULL,
    'user_id' INTEGER NOT NULL,
    'role'ENUM('admin', 'member') NOT NULL,
    PRIMARY KEY('group_id', 'user_id'),
    CONSTRAINT 'group_id_fk' FOREIGN KEY('group_id') REFERENCES 'groups'('id'),
    CONSTRAINT 'user_id_fk' FOREIGN KEY('user_id') REFERENCES 'users'('id')
)
CREATE TABLE 'exercises'(
    'id' INTEGER PRIMARY KEY AUTOINCREMENT,
    'name' TEXT NOT NULL,
    'description' TEXT NOT NULL,
)
CREATE TABLE 'progress'(
    'id' INTEGER PRIMARY KEY AUTOINCREMENT,
    'repetitions' INTEGER NOT NULL,
    'weight' INTEGER NOT NULL,
)
CREATE TABLE 'exercises_progress'(
    'exercise_id' INTEGER NOT NULL,
    'progress_id' INTEGER NOT NULL,
    PRIMARY KEY('exercise_id', 'progress_id'),
    CONSTRAINT 'exercise_id_fk' FOREIGN KEY('exercise_id') REFERENCES 'exercises'('id'),
    CONSTRAINT 'progress_id_fk' FOREIGN KEY('progress_id') REFERENCES 'progress'('id')
)