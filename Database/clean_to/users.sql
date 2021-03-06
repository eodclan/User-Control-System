CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `socialclubname` varchar(255) DEFAULT NULL,
  `password` varchar(2024) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `adminLevel` int(32) DEFAULT '0',
  `betaAcess` int(32) DEFAULT '0',
  `banAces` int(32) DEFAULT '1',
  `FirstLogin` datetime(6) DEFAULT NULL,
  `adminName` varchar(32) DEFAULT 'null',
  `usersig` varchar(140) DEFAULT NULL,
  `userava` varchar(256) DEFAULT 'themes/uploads/mike.jpg',
  `language` varchar(5) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`username`) USING BTREE;

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

