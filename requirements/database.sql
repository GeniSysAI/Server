-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2019 at 01:27 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `duhfjere`
--

-- --------------------------------------------------------

--
-- Table structure for table `a7fh46_logins`
--

CREATE TABLE `a7fh46_logins` (
  `id` int(11) NOT NULL,
  `app` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `a7fh46_loginsF`
--

CREATE TABLE `a7fh46_loginsF` (
  `id` int(11) NOT NULL,
  `app` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `a7fh46_settings`
--

CREATE TABLE `a7fh46_settings` (
  `id` int(11) NOT NULL,
  `version` varchar(50) NOT NULL,
  `nluID` varchar(255) NOT NULL,
  `nluAddress` varchar(255) NOT NULL,
  `tassID` varchar(255) NOT NULL,
  `tassAddress` varchar(255) NOT NULL,
  `tassDevices` int(11) NOT NULL,
  `jumpwayAPI` varchar(255) NOT NULL,
  `jumpwayLocation` varchar(255) NOT NULL,
  `jumpwayZone` varchar(255) NOT NULL,
  `JumpWayDevice` varchar(255) NOT NULL,
  `JumpWayAppID` varchar(255) NOT NULL,
  `JumpWayAppPublic` varchar(255) NOT NULL,
  `JumpWayAppSecret` varchar(255) NOT NULL,
  `JumpWayMqttUser` varchar(255) NOT NULL,
  `JumpWayMqttPass` varchar(255) NOT NULL,
  `phpmyadmin` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `domainString` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `a7fh46_users`
--

CREATE TABLE `a7fh46_users` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `iotjid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `mood` varchar(50) NOT NULL DEFAULT 'Unknown',
  `lastSeen` int(11) NOT NULL DEFAULT '0',
  `lastLocation` int(11) NOT NULL DEFAULT '0',
  `lastFloor` int(11) NOT NULL DEFAULT '0',
  `lastZone` int(11) NOT NULL DEFAULT '0',
  `lastUpdated` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tass_foscam_devices`
--

CREATE TABLE `tass_foscam_devices` (
  `id` int(11) NOT NULL,
  `jid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `RTSPuser` varchar(255) NOT NULL,
  `RTSPpass` varchar(255) NOT NULL,
  `RTSPip` varchar(255) NOT NULL,
  `RTSPport` varchar(255) NOT NULL,
  `RTSPendpoint` varchar(255) NOT NULL,
  `Stream` varchar(255) NOT NULL,
  `StreamAccess` varchar(255) NOT NULL,
  `StreamPort` varchar(255) NOT NULL,
  `URL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a7fh46_logins`
--
ALTER TABLE `a7fh46_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app` (`app`),
  ADD KEY `ip` (`ip`),
  ADD KEY `time` (`time`);

--
-- Indexes for table `a7fh46_loginsF`
--
ALTER TABLE `a7fh46_loginsF`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app` (`app`),
  ADD KEY `ip` (`ip`),
  ADD KEY `time` (`time`);

--
-- Indexes for table `a7fh46_settings`
--
ALTER TABLE `a7fh46_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tassDevices` (`tassDevices`),
  ADD KEY `tassID` (`tassID`),
  ADD KEY `JumpWayLocation` (`jumpwayLocation`),
  ADD KEY `JumpWayZone` (`jumpwayZone`);

--
-- Indexes for table `a7fh46_users`
--
ALTER TABLE `a7fh46_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lastSeen` (`lastSeen`),
  ADD KEY `lastUpdated` (`lastUpdated`);

--
-- Indexes for table `tass_foscam_devices`
--
ALTER TABLE `tass_foscam_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jid` (`jid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `a7fh46_logins`
--
ALTER TABLE `a7fh46_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `a7fh46_loginsF`
--
ALTER TABLE `a7fh46_loginsF`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `a7fh46_settings`
--
ALTER TABLE `a7fh46_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `a7fh46_users`
--
ALTER TABLE `a7fh46_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `tass_foscam_devices`
--
ALTER TABLE `tass_foscam_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;