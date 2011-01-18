<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:output method="html" indent="yes" encoding="UTF-8"/>
	<xsl:template match="/">
	/*=======Build Tables BOF=======*/<br/>
		<xsl:apply-templates select="/root" mode="Table"/>
	/*=======Build Tables EOF=======*/<br/>
		<br/>
	/*=======Build Stored Procedures BOF=======*/<br/>
		<xsl:apply-templates select="/root" mode="Procedure"/>
	/*=======Build Stored Procedures EOF=======*/
	</xsl:template>
	<xsl:template match="section" mode="Table">
	DROP TABLE IF EXISTS `<xsl:value-of select="@name" disable-output-escaping="yes"/>`;<br/>
	CREATE TABLE `<xsl:value-of select="@name" disable-output-escaping="yes"/>` (<br/>
		<xsl:for-each select="item">`<xsl:value-of select="@field_name" disable-output-escaping="yes"/>`
		<xsl:call-template name="Column">
				<xsl:with-param name="column" select="datatype/@type"/>
				<xsl:with-param name="length" select="datatype/@length"/>
				<xsl:with-param name="defalut" select="datatype/@defalut"/>
				<xsl:with-param name="null" select="datatype/@null"/>
				<xsl:with-param name="increment" select="datatype/@increment"/>
			</xsl:call-template>
			 COMMENT '<xsl:value-of select="@comment" disable-output-escaping="yes"/>'
			<xsl:if test="position() != last()">
				,<br/>
			</xsl:if>
		</xsl:for-each>
		<xsl:apply-templates mode="Primary" select="."/>
		<xsl:apply-templates mode="Unique" select="."/>
		<xsl:apply-templates mode="Index" select="."/>
		<br/>
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci comment='<xsl:value-of select="@comment" disable-output-escaping="yes"/>';<br/>
		<br/>
	</xsl:template>
	<xsl:template match="section" mode="Procedure">
	DELIMITER $$<br/>
	DROP PROCEDURE IF EXISTS `<xsl:value-of select="@name" disable-output-escaping="yes"/>_add`$$<br/>
	CREATE PROCEDURE `<xsl:value-of select="@name" disable-output-escaping="yes"/>_add`(<br/>
		<xsl:for-each select="item">
			<xsl:call-template name="Input">
				<xsl:with-param name="column" select="datatype/@type"/>
				<xsl:with-param name="length" select="datatype/@length"/>
				<xsl:with-param name="field_name" select="@field_name"/>
			</xsl:call-template>
		</xsl:for-each>
	OUT intResult INT,<br/>
	OUT strResult VARCHAR(100)<br/>
	)<br/>
	BEGIN<br/>
	DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;<br/>
	SET intResult = -2, strResult = '插入数据失败';<br/>
	IF NOT EXISTS (SELECT `<xsl:value-of select="item[datatype/@increment='1']/@field_name" disable-output-escaping="yes"/>` FROM <xsl:value-of select="@name" disable-output-escaping="yes"/> WHERE `<xsl:value-of select="item[datatype/@increment='1']/@field_name" disable-output-escaping="yes"/>`=_<xsl:value-of select="item[datatype/@increment='1']/@field_name" disable-output-escaping="yes"/> LIMIT 1) THEN<br/>
		START TRANSACTION;    #开始事务<br/>
		INSERT INTO <xsl:value-of select="@name" disable-output-escaping="yes"/> (<xsl:for-each select="item">
			<xsl:if test="not(datatype/@increment) or '0'=datatype/@increment">`<xsl:value-of select="@field_name" disable-output-escaping="yes"/>`<xsl:if test="position() != last()">,</xsl:if>
			</xsl:if>
		</xsl:for-each>) VALUES (<xsl:for-each select="item[datatype/@increment='0' or not(datatype/@increment)]">
			_<xsl:value-of select="@field_name" disable-output-escaping="yes"/>
			<xsl:if test="position() != last()"> ,</xsl:if>
		</xsl:for-each>);<br/>
		SET intResult = 0, strResult = '插入数据成功';<br/>
		 COMMIT;    #提交事务<br/>
	ELSE<br/>
		UPDATE <xsl:value-of select="@name" disable-output-escaping="yes"/> SET <xsl:for-each select="item[(datatype/@increment='0' or not(datatype/@increment)) and (not(other_attribute/@update) or '1'=other_attribute/@update)]">`<xsl:value-of select="@field_name" disable-output-escaping="yes"/>`=_<xsl:value-of select="@field_name" disable-output-escaping="yes"/>
			<xsl:if test="position() != last()">,</xsl:if>
		</xsl:for-each> WHERE `<xsl:value-of select="item[datatype/@increment='1']/@field_name" disable-output-escaping="yes"/>`=_<xsl:value-of select="item[datatype/@increment='1']/@field_name" disable-output-escaping="yes"/>;<br/>
		SET intResult = 0, strResult = '更新数据成功';<br/>
	END IF;<br/>
	END$$ <br/>
	DELIMITER ;<br/>
		<br/>
	</xsl:template>
	<xsl:template match="item" mode="Primary">
		<!--
		/**
		*Action: Create primary key
		*Input: item: Items need to created
		*Output: String
		*Creat: Vpc@2010-11-26
		*Update:
		*/
		-->
		<xsl:for-each select=".">
			<xsl:if test="'1' = other_attribute/@parimary">,<br/>PRIMARY KEY  (`<xsl:value-of select="@field_name" disable-output-escaping="yes"/>`)</xsl:if>
		</xsl:for-each>
	</xsl:template>
	<xsl:template match="item" mode="Unique">
		<!--
		/**
		*Action: Create unique key
		*Input: item: Items need to created
		*Output: String
		*Creat: Vpc@2010-11-26
		*Update:
		*/
		-->
		<xsl:for-each select=".">
			<xsl:if test="'1' = other_attribute/@unique">,<br/>UNIQUE KEY `UX_<xsl:value-of select="@field_name" disable-output-escaping="yes"/>` (`<xsl:value-of select="@field_name" disable-output-escaping="yes"/>`<xsl:if test="datatype/@length &gt; 255">(255)</xsl:if>)</xsl:if>
		</xsl:for-each>
	</xsl:template>
	<xsl:template match="item" mode="Index">
		<!--
		/**
		*Action: Create index key
		*Input: item: Items need to created
		*Output: String
		*Creat: Vpc@2010-11-26
		*Update:
		*/
		-->
		<xsl:variable name="IndexName">
			<xsl:for-each select=".">
				<xsl:if test="'1' = other_attribute/@index">_<xsl:value-of select="@field_name" disable-output-escaping="yes"/>
				</xsl:if>
			</xsl:for-each>
		</xsl:variable>
		<xsl:variable name="IndexValue">
			<xsl:for-each select=".">
				<xsl:if test="'1' = other_attribute/@index">`<xsl:value-of select="@field_name" disable-output-escaping="yes"/>`<xsl:if test="position() != last()">,</xsl:if>
				</xsl:if>
			</xsl:for-each>
		</xsl:variable>
		<xsl:if test="'' != $IndexName">,<br/>KEY `IX<xsl:value-of select="$IndexName"/>` (<xsl:value-of select="$IndexValue"/>)</xsl:if>
	</xsl:template>
	<xsl:template name="Column">
		<!--
		/**
		*Action: Table's columns
		*Input: column: column type
        *       length: column length
        *       defalut: column's default value
		*Output: String
		*Creat: Vpc@2010-11-26
		*Update:
		*/
		-->
		<xsl:param name="column" select="null"/>
		<xsl:param name="length" select="0"/>
		<xsl:param name="defalut" select="null"/>
		<xsl:param name="null" select="1"/>
		<xsl:param name="increment" select="0"/>
		<xsl:call-template name="Field">
			<xsl:with-param name="column" select="$column"/>
			<xsl:with-param name="length" select="$length"/>
			<xsl:with-param name="kind" select="'table'"/>
		</xsl:call-template>
		<xsl:choose>
			<xsl:when test="'1' = $null"> DEFAULT NULL</xsl:when>
			<xsl:when test="'0' = $null and '' != $defalut"> NOT NULL DEFAULT '<xsl:value-of select="$defalut" disable-output-escaping="yes"/>'</xsl:when>
			<xsl:when test="'0' = $null"> NOT NULL</xsl:when>
		</xsl:choose>
		<xsl:if test="'1' = $increment"> AUTO_INCREMENT</xsl:if>
	</xsl:template>
	<xsl:template name="Input">
		<!--
		/**
		*Action: Table's fields
		*Input: column: column type
        *       length: column length
        *       field_name: column's name
		*Output: String
		*Creat: Vpc@2010-11-26
		*Update:
		*/
		-->
		<xsl:param name="column" select="null"/>
		<xsl:param name="length" select="0"/>
		<xsl:param name="field_name" select="null"/>
		IN _<xsl:value-of select="$field_name" disable-output-escaping="yes"/>
		<xsl:text disable-output-escaping="yes"> </xsl:text>
		<xsl:call-template name="Field">
			<xsl:with-param name="column" select="$column"/>
			<xsl:with-param name="length" select="$length"/>
			<xsl:with-param name="kind" select="'procedure'"/>
		</xsl:call-template>,<br/>
	</xsl:template>
	<xsl:template name="Field">
		<!--
		/**
		*Action: Table's fields
		*Input: column: column type
        *       length: column length
        *       kind: for table or for procedure
		*Output: String
		*Creat: Vpc@2010-11-26
		*Update:
		*/
		-->
		<xsl:param name="column" select="null"/>
		<xsl:param name="kind" select="table"/>
		<xsl:param name="length" select="0"/>
		<xsl:choose>
			<xsl:when test="'varchar' = $column">
				<xsl:call-template name="_t">
					<xsl:with-param name="value" select="$column"/>
					<xsl:with-param name="type" select="'l2u'"/>
				</xsl:call-template>(<xsl:value-of select="$length" disable-output-escaping="yes"/>)<xsl:call-template name="Collate">
					<xsl:with-param name="kind" select="$kind"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:when test="'text' = $column">
				<xsl:call-template name="_t">
					<xsl:with-param name="value" select="$column"/>
					<xsl:with-param name="type" select="'l2u'"/>
				</xsl:call-template>
				<xsl:call-template name="Collate">
					<xsl:with-param name="kind" select="$kind"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="_t">
					<xsl:with-param name="value" select="$column"/>
					<xsl:with-param name="type" select="'l2u'"/>
				</xsl:call-template>(<xsl:value-of select="$length" disable-output-escaping="yes"/>)
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template name="Collate">
		<!--
		/**
		*Action: Show collate
		*Input: kind: for table or for procedure
		*Output: String
		*Creat: Vpc@2010-11-26
		*Update:
		*/
		-->
		<xsl:param name="kind" select="table"/>
		<xsl:if test="'table' = $kind"> COLLATE utf8_unicode_ci</xsl:if>
	</xsl:template>
	<xsl:template name="_t">
		<!--
		/**
		*Action: LowerCase 2 UpperCase or UpperCase 2 LowerCase
		*Input: value: The value will to be changed
        *       type: l2u or u2l
		*Output: String
		*Creat: Vpc@2010-11-26
		*Update:
		*/
		-->
		<xsl:param name="value" select="int"/>
		<xsl:param name="type" select="l2u"/>
		<xsl:variable name="uppercase">ABCDEFGHIJKLMNOPQRSTUVWXYZ</xsl:variable>
		<xsl:variable name="lowercase">abcdefghijklmnopqrstuvwxyz</xsl:variable>
		<xsl:choose>
			<xsl:when test="'l2u' = $type">
				<xsl:value-of select="translate($value, $lowercase, $uppercase)"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="translate($value, $uppercase, $lowercase)"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
