# Task Managament Application

This straightforward yet effective application allows users to effortlessly view, add, and delete tasks. 

## Features

- **Create Tasks**
- **View Tasks**
- **Delete tasks**

## To run Task Managment application in your server, you'll need 

#### PHP (version 7.4 or higher)
#### Composer
#### MySQL or a database of your choice

1. **Clone the repository**:
    - Git clone ..

2. **Install Dependencies**:
    - composer install

3. **Set up environment**:
    - set up .env (recreate .env.example and add your database information)

4. **Setup database**:
    - set up database **task_manager**, create table **tasks** with columns:
      - **id** (INT (auto increment), primary key)
      - **task_name** (VARCHAR(255))
      - **task_description** (TEXT)
      - **created_at** (DATETIME)
        
5. **Start application**:
    - cd public
    - php -S localhost:8000
  
### Result

![image](https://github.com/liga4/IntelligentSystems_assignment/assets/141454772/b4add503-43a7-46a9-af17-1e776d140d42)  
![image](https://github.com/liga4/IntelligentSystems_assignment/assets/141454772/1b92db0d-5b4e-4122-a961-fb2d2147c30c)

