<?php

use yii\db\Migration;

/**
 * Class m241015_121819_seed_users
 */
class m241015_121819_seed_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();

        try {
            $this->execute(<<<SQL
            INSERT INTO `users` (`id`, `first_name`, `last_name`) VALUES
            (1, 'Thomas', 'Pagac'),
            (2, 'Sonny', 'Haley'),
            (3, 'Hanna', 'Satterfield'),
            (4, 'Mina', 'Durgan'),
            (5, 'Wendell', 'Conroy'),
            (6, 'Myrtle', 'Quitzon'),
            (7, 'Elise', 'Bernhard'),
            (8, 'Abbigail', 'Tillman'),
            (9, 'Elda', 'Streich'),
            (10, 'Jay', 'Streich'),
            (11, 'Dion', 'Stracke'),
            (12, 'Braulio', 'Prosacco'),
            (13, 'Lizeth', 'Champlin'),
            (14, 'Ruthie', 'O\'Hara'),
            (15, 'Elody', 'Adams'),
            (16, 'Gordon', 'Reichel'),
            (17, 'Forest', 'Reilly'),
            (18, 'Kieran', 'Conroy'),
            (19, 'Meredith', 'O\'Connell'),
            (20, 'Vladimir', 'Moore'),
            (21, 'Jermaine', 'Willms'),
            (22, 'Granville', 'Toy'),
            (23, 'Dimitri', 'McLaughlin'),
            (24, 'Sylvester', 'Bode'),
            (25, 'Raphael', 'Jerde'),
            (26, 'Natalie', 'Reichert'),
            (27, 'Kenna', 'Connelly'),
            (28, 'Trever', 'Stehr'),
            (29, 'Colin', 'Kiehn'),
            (30, 'Bret', 'Heaney'),
            (31, 'Sabrina', 'Kiehn'),
            (32, 'Evalyn', 'Labadie'),
            (33, 'Virginia', 'Wintheiser'),
            (34, 'Rashawn', 'Douglas'),
            (35, 'Wilson', 'Pouros'),
            (36, 'Cheyanne', 'Zieme'),
            (37, 'Carissa', 'Bauch'),
            (38, 'Jammie', 'Howe'),
            (39, 'Titus', 'Kirlin'),
            (40, 'Jeanie', 'Stark'),
            (41, 'Mathew', 'Hermann'),
            (42, 'Sherwood', 'Jacobi'),
            (43, 'Guy', 'Nader'),
            (44, 'Tina', 'Considine'),
            (45, 'Brooks', 'Grimes'),
            (46, 'Odell', 'Funk'),
            (47, 'Gabriel', 'Jakubowski'),
            (48, 'Hubert', 'Lynch'),
            (49, 'Delores', 'Reilly'),
            (50, 'Jamison', 'Mann'),
            (51, 'Jany', 'Bartoletti'),
            (52, 'Marlin', 'Trantow'),
            (53, 'Jeanette', 'Eichmann'),
            (54, 'Jason', 'Mante'),
            (55, 'Shaina', 'Doyle'),
            (56, 'Hallie', 'Vandervort'),
            (57, 'Georgianna', 'Lind'),
            (58, 'Lucy', 'Quitzon'),
            (59, 'Maryam', 'Hessel'),
            (60, 'Amelie', 'Harvey'),
            (61, 'Gillian', 'Hamill'),
            (62, 'Estelle', 'Leuschke'),
            (63, 'Misty', 'Lueilwitz'),
            (64, 'Liza', 'Runte'),
            (65, 'Alba', 'Schaden'),
            (66, 'Reanna', 'Nolan'),
            (67, 'Robb', 'Beier'),
            (68, 'Tess', 'Bernier'),
            (69, 'Britney', 'Casper'),
            (70, 'Kyra', 'Tillman'),
            (71, 'Kenna', 'Rohan'),
            (72, 'Sonya', 'Howe'),
            (73, 'Maybell', 'Kuhn'),
            (74, 'Herminia', 'Lubowitz'),
            (75, 'Nicklaus', 'Purdy'),
            (76, 'Terence', 'Koelpin'),
            (77, 'Dayna', 'Dickinson'),
            (78, 'Gwen', 'Klocko'),
            (79, 'Vivien', 'Gutmann'),
            (80, 'Vicente', 'O\'Kon'),
            (81, 'Garland', 'Christiansen'),
            (82, 'Demarcus', 'Ratke'),
            (83, 'Kyler', 'Daniel'),
            (84, 'Shanon', 'Leannon'),
            (85, 'Lucy', 'Tillman'),
            (86, 'Clinton', 'Funk'),
            (87, 'Rosalind', 'Fay'),
            (88, 'Violette', 'Hintz'),
            (89, 'Viola', 'Tremblay'),
            (90, 'Jaydon', 'Hand'),
            (91, 'Mathew', 'Huels'),
            (92, 'Adrianna', 'Kuphal'),
            (93, 'Isac', 'Homenick'),
            (94, 'Vidal', 'O\'Hara'),
            (95, 'Hudson', 'Gerhold'),
            (96, 'Roselyn', 'Abshire'),
            (97, 'Evert', 'Walter'),
            (98, 'Hobart', 'O\'Kon'),
            (99, 'Axel', 'Kozey'),
            (100, 'Theresia', 'Pfeffer');
            SQL);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('users');
    }
}
